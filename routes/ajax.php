<?php

use App\Middlewares\Ajax\CsrfMiddleware;
use App\Middlewares\Ajax\GuestMiddleware;
use App\Middlewares\Ajax\UserMiddleware;
use Slim\Routing\RouteCollectorProxy;

$app->group('/users', function (RouteCollectorProxy $group) {

    $group->get('', [App\Controllers\HomeController::class, 'users'])->setName('ajax.users');

})->add(new CsrfMiddleware)->add(new GuestMiddleware);