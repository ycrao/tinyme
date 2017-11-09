<?php


/**
 * HomeController
 */
class HomeController
{
    /**
     * index
     */
    public static function index()
    {
        return Flight::render('index');
        //echo 'Hello Flight!';
    }

}
