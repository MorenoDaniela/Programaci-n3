<?php

namespace Config;

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuariosController;
use App\Middlewares\BeforeMiddleware;
use App\Middlewares\UsuarioValidateMiddleware;
use App\Middlewares\RegistroMiddleware;
use App\Middlewares\LoginMiddleware;


return function ($app) 
{
    $app->post('/registro',UsuariosController::class . ':add')->add(RegistroMiddleware::class);
    $app->post('/login', UsuariosController::class . 'login')->add(LoginMiddleware::class);

    /*
    $app->group('/usuarios', function (RouteCollectorProxy $group) {
        $group->get('[/]', UsuariosController::class . ':getAll');
        $group->get('/:id', AlumnosController::class . ':getAll');
        $group->post('[/]', AlumnosController::class . ':add')->add(AlumnoValidateMiddleware::class);
        $group->put('/:id', AlumnosController::class . ':getAll')->add(AlumnoValidateMiddleware::class);
        $group->delete('/:id', AlumnosController::class . ':getAll');
    })->add(new BeforeMiddleware());

    $app->group('/materias', function (RouteCollectorProxy $group) {
        $group->get('[/]', AlumnosController::class . ':getAll');
        $group->get('/:id', AlumnosController::class . ':getAll');
        $group->post('[/]', AlumnosController::class . ':getAll');
        $group->put('/:id', AlumnosController::class . ':getAll');
        $group->delete('/:id', AlumnosController::class . ':getAll');
    });*/
};