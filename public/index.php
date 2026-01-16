<?php

use app\utils\Helper;

require __DIR__ . '/../vendor/autoload.php';

// It is better practice to not use static methods for everything. It makes your
// app much more difficult to unit test easily.
// This is important as it connects any static calls to the same $app object
$app = Flight::app();

// Bootstrap application
require __DIR__ . '/../app/config/bootstrap.php';

// Whip out the ol' router and we'll pass that to the routes file
$router = $app->router();

// Load routes
require __DIR__ . '/../app/routes/api.php';


// some views pages
$router->get('/',function() use ($app) {
	$app->render('index', [
        'name' => 'TinyMe',
        'desc' => 'A tiny PHP framework based on FlightPHP and Medoo.',
    ]);
});

// 404 handler
$app->map('notFound', function () use ($app) {
    if (Helper::expectsJson($app->request())) {
        $app->jsonHalt(['code' => 400, 'msg' => 'not found!', 'data' => null], 404);
    } else {
        $app->render('404');
    }
});

// Start the application
$app->start();
