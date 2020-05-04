<?php

use \Firebase\JWT\JWT;
require_once __DIR__ .'/vendor/autoload.php';
include_once './data.php';
 class User
 {
     public $nombre;
     public $id=0;
     public $obraSocial;
     public $dni;
     public $clave;
     public $tipo;

     public function __construct($nombre,$obraSocial,$clave,$dni,$tipo)
     {
        $this->nombre=$nombre;
        $this->id=mt_rand();
        $this->obraSocial=$obraSocial;
        $this->clave=$clave;
        $this->dni=$dni;
        $this->tipo=$tipo;
     }

     public static function Singin($nombre,$obraSocial,$clave,$dni,$type)
     {
        $return=false;
        $newUser = new User($nombre,$obraSocial,$clave,$dni,$type);
        //var_dump($newUser);
        if (Data::save("users.txt",$newUser))
        {
            $return=true;
        }
        return $return;
        
     }

     public static function Login($nombre,$clave)
     {
        $return=false;
        $response = Data::MATI("users.txt");

        if ($response!=false)
        {
            var_dump($response);
            $key = "example_key";
            foreach ($response as $user)
            {
            if ($user!= PHP_EOL && User::validar($nombre, $clave, $user->nombre, $user->clave))
                {
                    $payload = array(
                        "name" => $nombre,
                        "id" => $user->id,
                        "pass" => $clave,
                        "dni" => $user->dni,
                        "tipo" => $user->tipo,
                        "obraSocial" => $user->obraSocial
                    );
                    $return=true;
                break;
                }
            }
            if ($return)
            {
                $return = JWT::encode($payload, $key);
            }
        }
        
        return $return;
     }

     public static function validar($nombre,$clave, $nombreNew, $passNew)
     {
        $return = false;
         if ($passNew == $clave && $nombre==$nombreNew)
         {
            $return = true;
         }
        return $return;
     }
     
     public static function IsAdmin($token)
     {
        $response=false;
        try
        {
            $users = JWT::decode($token,"example_key", array("HS256"));
        }catch(Exception $ex)
        {
            $response = false;
        }
        
        
        $lista = Data::MATI('users.txt');
        
        if($users)
        {
            if($users->tipo=="admin")
            {
               $response=true;
            }
        }
        return $response;
     }

     public static function notAdmin($token)
     {
        $response=false;
        try
        {
            $users = JWT::decode($token,"example_key", array("HS256"));
        }catch(Exception $ex)
        {
            $response = false;
        }
        
        
        $lista = Data::MATI('users.txt');
        
        if($users)
        {
            if($users->tipo=="user")
            {

               $response=$users->name;
            }
        }
        return $response;
     }

     



}