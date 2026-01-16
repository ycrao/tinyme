<?php

use app\controllers\AuthController;
use app\controllers\PageController;
use flight\Engine;
use flight\net\Router;
use app\middlewares\UserAuthMiddleware;

/** 
 * @var Router $router 
 * @var Engine $app
 */
$router->group('/api', function(Router $router) use ($app) {
    $router->post('/login', [AuthController::class, 'login']);
});

$router->group('/api', function (Router $router) use ($app) {
    // page routes
    $router->get('/pages', [PageController::class, 'index']);
    $router->post('/page', [PageController::class, 'create']);
    $router->get('/page/@id', [PageController::class, 'show']);
    $router->put('/page/@id', [PageController::class, 'update']);
    $router->delete('/page/@id', [PageController::class, 'delete']);
}, [UserAuthMiddleware::class]);

