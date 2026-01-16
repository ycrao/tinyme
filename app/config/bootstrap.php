<?php

use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;
use Medoo\Medoo;
use flight\Cache;
use app\utils\Helper;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Set timezone
date_default_timezone_set(Helper::env('APP_TIMEZONE', 'UTC'));

// Error reporting level (E_ALL recommended for development)
error_reporting(E_ALL);

// Character encoding
if (function_exists('mb_internal_encoding') === true) {
	mb_internal_encoding('UTF-8');
}

// Default Locale Change as needed or feel free to remove.
if (function_exists('setlocale') === true) {
	setlocale(LC_ALL, 'en_US.UTF-8');
}

/**********************************************
 *           FlightPHP Core Settings          *
 **********************************************/
// Get the $app var to use below
if (empty($app) === true) {
	$app = Flight::app();
}


// Refer to this constant to get the project root directory
define('PROJECT_ROOT', __DIR__ . '/../..');

// This autoloads your code in the app directory so you don't have to require_once everything
// You'll need to namespace your classes with "app\folder\" to include them properly
$app->path(PROJECT_ROOT);


// Core config variables
$app->set('flight.base_url', '/',);           // Base URL for your app. Change if app is in a subdirectory (e.g., '/myapp/')
$app->set('flight.case_sensitive', false);    // Set true for case sensitive routes. Default: false
$app->set('flight.log_errors', true);         // Log errors to file. Recommended: true in production
$app->set('flight.handle_errors', true);     // Let Tracy handle errors if false. Set true to use Flight's error handler
$app->set('flight.views.path', PROJECT_ROOT . '/app/views'); // Path to views/templates
$app->set('flight.views.extension', '.php');  // View file extension (e.g., '.php', '.latte')
$app->set('flight.content_length', false);    // Send content length header. Usually false unless required by proxy



// Register database
$app->register('db', Medoo::class, [
    [
        'type' => 'mysql',
        'host' => Helper::env('DB_HOST', 'localhost'),
        'port' => Helper::env('DB_PROT', 3306),
        'database' => Helper::env('DB_DATABASE', 'tinyme'),
        'username' => Helper::env('DB_USERNAME', 'root'),
        'password' => Helper::env('DB_PASSWORD', 'root'),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ]
]);

// Register logger
$app->register('logger', Logger::class, ['tinyme'], function($logger) {
    $logPath = __DIR__ . '/../storage/logs/app.log';
    $logger->pushHandler(new StreamHandler($logPath, Level::Debug));
});

// Register cache
$app->register('cache', Cache::class, [__DIR__ . '/../storage/cache']);
