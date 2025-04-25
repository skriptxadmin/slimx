<?php

namespace App\Middlewares\Web;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;

class GuestMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        // Optional: Handle the incoming request
        // ...

        if(empty($_SESSION['userId'])){
            $response = $handler->handle($request);
        

            return $response;
        }
        // Invoke the next middleware and get response
      

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('page.user.dashboard');
        $response = $handler->handle($request);
        $uri = $request->getUri();
        return $response
        ->withHeader('Location', $url)
        ->withStatus(302);

        // Optional: Handle the outgoing response
        // ...
    }
}