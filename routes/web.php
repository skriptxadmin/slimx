<?php 

use Slim\Routing\RouteCollectorProxy;

use App\Middlewares\Web\UserMiddleware;
use App\Middlewares\Web\GuestMiddleware;


$app->get('/', [App\Controllers\HomeController::class, 'index'])->setName('page.home');

$app->get('/guest', [App\Controllers\Guest\IndexController::class, 'index'])
->add(new GuestMiddleware())->setName('page.guest');


$app->get('/404', [App\Controllers\ErrorController::class, 'web_not_found'])->setName('web.404');
$app->get('/500', [App\Controllers\ErrorController::class, 'web_app_error'])->setName('web.500');

