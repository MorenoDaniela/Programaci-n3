<?php

namespace Config;

use Slim\Routing\RouteCollectorProxy;
//Controllers
use App\Controllers\UsuariosController;
use App\Controllers\MascotasController;
use App\Controllers\TurnosController;
//middles
use App\Middleware\BeforeMiddleware;
use App\Middleware\UsuarioValidateMiddleware;
use App\Middleware\RegistroMiddleware;
use App\Middleware\LoginMiddleware;
use App\Middleware\RegistroMascotaMiddleware;
use App\Middleware\RegistroTurnoMiddleware;
use App\Middleware\TurnosVeterinariosMiddleware;


return function ($app) 
{
    $app->post('/registro',UsuariosController::class . ':add')->add(RegistroMiddleware::class);
    $app->post('/login',UsuariosController::class . ':login')->add(LoginMiddleware::class);
    $app->post('/mascota',MascotasController::class . ':add')->add(RegistroMascotaMiddleware::class);

    $app->group('/turnos', function (RouteCollectorProxy $turnos) 
    {
        $turnos->post('[/mascota]', TurnosController::class . ':add')->add(RegistroTurnoMiddleware::class);
        $turnos->get('/{id}', TurnosController::class . ':turnosGetAll')->add(TurnosVeterinariosMiddleware::class);
        //$group->post('[/]', AlumnosController::class . ':add')->add(AlumnoValidateMiddleware::class);
    });
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