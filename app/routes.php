<?php

//routes

    /*
    Flight::route('GET /', function () {
        return Flight::render('index');
    });
    */

    // home index page
    Flight::route('GET /', ['HomeController', 'index']);

    /*-----api service start-----*/
    // post login
    Flight::route('POST /api/login', ['ApiController', 'login']);

    // get current user own pages
    Flight::route('GET /api/pages', ['ApiController', 'getOwnPages']);

    // create page
    Flight::route('POST /api/page', ['ApiController', 'createPage']);

    // get page by id
    Flight::route('GET /api/page/@id', ['ApiController', 'getPage']);

    // update page
    Flight::route('PUT /api/page/@id', ['ApiController', 'updatePage']);

    // delete page
    Flight::route('DELETE /api/page/@id', ['ApiController', 'deletePage']);
    /*-----api service end-----*/