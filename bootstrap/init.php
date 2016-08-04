<?php

define('START_TIME', microtime());
define('APP_PATH', __DIR__.'/../app');

require __DIR__.'/../vendor/autoload.php';

//include helpers.php
require APP_PATH.'/core/helpers.php';

//Load Dotenv
$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

Flight::set(require APP_PATH.'/config/app.php');

//setting url case_sensitive, default false
Flight::set('flight.case_sensitive', true);

/*-----
Flight autoload start
-----*/

//controllers
Flight::path(Flight::get('flight.controllers.path'));

//models
Flight::path(Flight::get('flight.models.path'));

//core
Flight::path(Flight::get('flight.core.path'));

/*-----
Flight autoload end
-----*/
