<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Mascota;
use \Firebase\JWT\JWT;
use App\Models\Usuario;

class MascotasController 
{

    /*   public function getAll(Request $request, Response $response, $args)
    {
        $rta = json_encode(mascota::all());

        // $response->getBody()->write("Controller");
        $response->getBody()->write($rta);

        return $response;
    }*/

    public function add(Request $request, Response $response, $args)
    {
        $header = getallheaders();
        $token = $header['token'];

        $decoded = JWT::decode($token, 'usuario', array('HS256'));

        $mascota = new Mascota;
        $respuesta = $request->getParsedBody();
        $response->withHeader('Content-type', 'application/json');
        $mascota->nombre = $respuesta['nombre'];
        $mascota->edad = $respuesta['edad'];
        $mascota->id_cliente = $decoded->id;
        $rta = json_encode(array("ok" => $mascota->save()));
        $response->getBody()->write($rta);
        
        return $response;
    }
}