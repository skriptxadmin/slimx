<?php
namespace App\Controllers;

use App\Helpers\CSRF;
use function _\get;
use Slim\App;
use Slim\Routing\RouteContext;
use Smarty\Smarty;

class Controller
{

    public function view($request, $tpl, $data = null, $page_cache = null)
    {

        $smarty = new Smarty();

        $smarty->setTemplateDir(ABSPATH . '/smarty/templates/');
        $smarty->setCompileDir(ABSPATH . '/smarty/templates_c/');
        $smarty->setConfigDir(ABSPATH . '/smarty/configs/');
        $smarty->setCacheDir(ABSPATH . '/smarty/cache/');

       
        
        $response = new \Slim\Psr7\Response();

        $routeContext = RouteContext::fromRequest($request);
        $route        = $routeContext->getRoute();
        $routeName    = $route->getName();
        $smarty->assign('pageClass', '');
        if ($routeName) {

            $explode = explode('.', $routeName);
            $implode = implode(' ', $explode);
            $smarty->assign('pageClass', $implode);
        }

        $meta = [
            'title'       => get($_ENV, 'APP_TITLE', ''),
            'description' => get($_ENV, 'APP_DESCRIPTION', ''),
            'image'       => get($_ENV, 'APP_IMAGE', ''),
            'url'         => get($_ENV, 'APP_URL', ''),
        ];
        $smarty->assign('meta', $meta);

        if (! empty($data)) {

            foreach ($data as $key => $value) {

                $smarty->assign($key, $value);
            }
        }

        $csrfContext = $_ENV['AJAX_CSRF_CONTEXT'];
        $csrf        = new CSRF($csrfContext);
        $csrf->clearHashes($csrfContext);
        $hash = $csrf->string($csrfContext);
        $smarty->assign('csrfToken', $hash);

        $smarty->assign('isUserLoggedIn', ! empty($_SESSION['userId']));
        $smarty->assign('url', $_ENV['APP_URL']);

        if((get($_ENV, 'APP_ENV', 'production') == 'production')){
            $smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
            $smarty->cache_lifetime = 3600;  
            $smarty->registerFilter("output", [$this, 'minify_html']);
        }

       
        $smarty->registerPlugin("function", 'env', [$this, 'env']);

        $html = $smarty->fetch($tpl . '.html', $page_cache);

        $response->getBody()->write($html);

        return $response;

    }

    public function json($data = [], $status = 200)
    {

        $payload = json_encode($data);

        $response = new \Slim\Psr7\Response();

        $response->getBody()->write($payload);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);

    }

    public function redirectTo($path)
    {
        $response = new \Slim\Psr7\Response();
        $url      = $_ENV['APP_URL'] . $path;
        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }

    public function minify_html($tpl_output, $template)
    {
        $tpl_output = preg_replace('![\t ]*[\r\n]+[\t ]*!', '', $tpl_output);
        return $tpl_output;
    }

    public function env($params = [])
    {

        if (empty($params['var'])) {

            return '';
        }

        return get($_ENV, get($params, 'var', 'DEFAULT'), '');
    }
}
