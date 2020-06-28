<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Usuario;

class UsuariosController 
{

    /*   public function getAll(Request $request, Response $response, $args)
    {
        $rta = json_encode(Usuario::all());

        // $response->getBody()->write("Controller");
        $response->getBody()->write($rta);

        return $response;
    }*/

    public function add(Request $request, Response $response, $args)
    {
       // var_dump($response->getStatus());
       // if ($response->getStatus==200)
        //{
            $usuario = new Usuario;
            $respuesta = $request->getParsedBody();
            $usuario->email = $respuesta['email'];
            $usuario->password = $respuesta['password'];
            $usuario->tipo = $respuesta['tipo'];
            
            $rta = json_encode(array("ok" => $usuario->save()));
            $response->getBody()->write($rta);
            /*
        }else
        {
            $rta = json_encode(array("Error, el status no es 200"));
            $response->getBody()->write($rta);
        }*/
        
        return $response->withHeader('Content-type', 'application/json');;
    }

    public function login(Request $request, Response $response, $args)
    {
        $rta = json_encode(Usuario::all());
        
        $response->getBody()->write($rta);

        return $response->withHeader('Content-type', 'application/json');;
    }


    
}