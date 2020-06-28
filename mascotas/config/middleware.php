<?php

//use Config\Database;
namespace Config;
use Slim\App;
use App\Middlewares\BeforeMiddleware;
use App\Middlewares\AfterMiddleware;
use App\Middlewares\RegistroMiddleware;


return function (App $app) {
    $app->addBodyParsingMiddleware();

    //$app->add(new RegistroMiddleware());
    //$app->add(new AfterMiddleware());
    //$app->add(BeforeMiddleware::class);
    
};