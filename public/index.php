<?php

define('ABSPATH', __DIR__ . '/..');
define('PUBLIC_PATH', __DIR__ . '/.');

session_start();

require ABSPATH . '/vendor/autoload.php';

use App\Middlewares\Globals\LoggerMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use App\Middlewares\Globals\CorsMiddleware;
use Slim\Middleware\BodyParsingMiddleware;


$dotenv = \Dotenv\Dotenv::createImmutable(ABSPATH);

$dotenv->load();

date_default_timezone_set($_ENV['APP_TIMEZONE']);

$app = AppFactory::create();

// uncomment only if you need cors
/*
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(new CorsMiddleware());
*/
$app->addBodyParsingMiddleware();


require ABSPATH . '/routes/web.php';

if ($_ENV['APP_ENV'] != 'production') {

    require ABSPATH . '/routes/database.php'; // comment this line on production
}

require ABSPATH . '/routes/ajax.php';

$app->add(new LoggerMiddleware());

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

if ($_ENV['APP_ENV'] != 'production') {

    $errorMiddleware->setDefaultErrorHandler(
        function (Request $request, Throwable $exception, bool $displayErrorDetails) use ($app) {
            $isAjax = strtolower($request->getHeaderLine('X-Requested-With')) === 'xmlhttprequest';

            $response = $app->getResponseFactory()->createResponse();
            if ($isAjax) {
                $payload = ['error' => 'Application Error'];
                $response->getBody()->write(json_encode($payload));
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(500);
            }
            // $response->getBody()->write('Custom 404 - This page does not exist.');
            $routeParser = $app->getRouteCollector()->getRouteParser();
            $url         = $routeParser->urlFor('web.500'); // '404' is the name of the route
                                                            // return $response ->withHeader('Location', $url)->withStatus(404);
            return $response->withHeader('Location', $url)->withStatus(302);
        }
    );

}

// Custom 404 Error Handler
$errorMiddleware->setErrorHandler(HttpNotFoundException::class,
    function (Request $request, Throwable $exception, bool $displayErrorDetails) use ($app) {
      $isAjax = strtolower($request->getHeaderLine('X-Requested-With')) === 'xmlhttprequest';

            $response = $app->getResponseFactory()->createResponse();
           file_put_contents(__DIR__.'/./x.txt', $request->getHeaderLine('X-Requested-With'));
            if ($isAjax) {
                $payload = ['error' => 'Unidentified Route'];
                $response->getBody()->write(json_encode($payload));
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
            }
            // $response->getBody()->write('Custom 404 - This page does not exist.');
            $routeParser = $app->getRouteCollector()->getRouteParser();
            $url         = $routeParser->urlFor('web.404'); // '404' is the name of the route
                                                            // return $response ->withHeader('Location', $url)->withStatus(404);
            return $response->withHeader('Location', $url)->withStatus(302);
  
       
    }
);

$app->run();
