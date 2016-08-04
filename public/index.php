<?php

/**
 * TinyMe Application
 */
require __DIR__."/../bootstrap/init.php";
Flight::before('start', ['TinyMe', 'bootstrap']);
Flight::start();

