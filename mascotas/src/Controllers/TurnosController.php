<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Turno;
//use \Firebase\JWT\JWT;
//use App\Models\Turno;

class TurnosController 
{

    /*   public function getAll(Request $request, Response $response, $args)
    {
        $rta = json_encode(turno::all());

        // $response->getBody()->write("Controller");
        $response->getBody()->write($rta);

        return $response;
    }*/

    public function add(Request $request, Response $response, $args)
    {
        //$header = getallheaders();
        //$token = $header['token'];

        //$decoded = JWT::decode($token, 'usuario', array('HS256'));
        $turno = new Turno;
        $respuesta = $request->getParsedBody();
        $response->withHeader('Content-type', 'application/json');
        $turno->id_mascota = $respuesta['id_mascota'];
        $turno->fecha = $respuesta['fecha'];
        $turno->hora = $respuesta['hora'];
        $turno->id_veterinario = $respuesta['id_veterinario'];
        $rta = json_encode(array("ok" => $turno->save()));
        $response->getBody()->write($rta);
        
        return $response;
    }

    public function turnosGetAll(Request $request, Response $response, $args)
    {
        $header = getallheaders();
        $token = $header['token'];
        $decoded = JWT::decode($token, 'usuario', array('HS256'));

        $mascotas = json_decode(Mascota::where('id_cliente',$decoded->id));

        date_default_timezone_set('america/argentina/buenos_aires');
        $turnos = Turno::all();
        $veterinarios = json_decode(Usuario::where('tipo',"veterinario")->get());

        $fecha = date("d-m-Y");
        $hora = date("H:i");
        $array = array ("09:00", "09:30","10:00" ,"10:30", "11:00",
                        "11:30","12:00","12:30","13:00","13:30",
                        "14:00","14:30","15:00","15:30","16:00","16:30");
        foreach ($veterinarios as $vet)
        {
            foreach ($array as $unaHora)
            {
                if ($unaHora > $hora)
                {
                    $turnos = Turno::whereRaw('fecha = ? AND hora = ? AND id_veterinario',array($fecha,$unaHora,$vet->id))->get();
                    if ($turnos == [])
                    {
                        $t = new Turno;
                        $t->fecha = $fecha;
                        $t->id_veterinario = $vet->id;
                        $t->hora = $unaHora;
                        $t->id_mascota = $mascotas[0]->id;

                    }
                }
            }
        }


        $id_vet = $args['id'];

        $turnos = Turno::where('id_veterinario', $id_vet)
        ->join('mascotas', 'mascotas.id', 'turnos.id_mascota')->get();
        //->join ('usuarios', 'usuarios.id','mascotas.id_cliente')->get();
        
        $response->withHeader('Content-type', 'application/json');
        
        $rta = json_encode(array("ok" => $turnos));
        $response->getBody()->write($rta);
        
        return $response;
    }
}