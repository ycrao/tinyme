<?php


use \Flight;

/**
 * HomeController
 */
class HomeController
{

    public static function index()
    {
        return Flight::render('index');
        //echo 'Hello Flight!';
    }

}
