<?php

//routes

    /*
    Flight::route('GET /', function(){
        return Flight::render('index');
    });
    */

    Flight::route('GET /', ['HomeController', 'index']);
