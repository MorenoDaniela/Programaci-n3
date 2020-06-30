<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Usuario;
use \Firebase\JWT\JWT;


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
            $usuario = new Usuario;
            $respuesta = $request->getParsedBody();
            $response->withHeader('Content-type', 'application/json');
            $usuario->email = $respuesta['email'];
            $usuario->password = $respuesta['password'];
            $usuario->tipo = $respuesta['tipo'];
            $rta = json_encode(array("ok" => $usuario->save()));
            $response->getBody()->write($rta);
        
        return $response;
    }

    public function login(Request $request, Response $response, $args)
    {
        
        $body = $request->getParsedBody();

        $usuarioEncontrado = json_decode(Usuario::whereRaw('email = ? AND password = ?',array($body['email'],$body['password']))->get());

        $key = 'usuario';
        $payload = array(
            "email" => $usuarioEncontrado[0]->email,
            "password" => $usuarioEncontrado[0]->password,
            "tipo" => $usuarioEncontrado[0]->tipo,
            "id" =>$usuarioEncontrado[0]->id);

        //$response->withStatus(200);
        
        $response->getBody()->write(JWT::encode($payload,$key));
        //$existingContent = (string) $response->getBody();
        //$response->getBody()->write($existingContent);

        return $response->withHeader('Content-type', 'application/json');;
    }


    
}