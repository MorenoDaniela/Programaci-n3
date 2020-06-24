<?php

use \Firebase\JWT\JWT;
require_once __DIR__ .'/vendor/autoload.php';
include_once './datos.php';
 class User
 {
     public $email;
     public $clave;
     public $tipo;

     public function __construct($email,$clave,$tipo)
     {
        $this->email=$email;
        $this->clave=$clave;
        $this->tipo=$tipo;
     }

     public static function Singin($email,$clave,$tipo)
     {
        $return=false;
        $newUser = new User($email,$clave,$tipo);
        //var_dump($newUser);
        if (Datos::GuardarJSON("users.json",$newUser))
        {
            $return=true;
        }
        return $return;
     }

     public static function Login($email,$clave)
     {
        $return=false;
        $response = Datos::TraerJSON("users.json");

        if ($response!=false)
        {
            
            $key = "example_key";//cambiar por la key que pida
            foreach ($response as $user)
            {
            if (User::validar($email, $clave, $user->email, $user->clave))
                {
                    $payload = array(
                        "email" => $email,
                        //"id" => $user->id,
                        "clave" => $clave,
                       // "dni" => $user->dni,
                        "tipo" => $user->tipo,
                        //"obraSocial" => $user->obraSocial
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

    public static function validar($email,$clave, $emailNew, $passNew)
    {
        $return = false;
         if ($passNew == $clave && $email==$emailNew)
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
        
        
        $lista = Datos::TraerJson('users.json');
        
        if($users)
        {
            if($users->tipo=="encargado")
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
        
        
        $lista = Datos::TraerJSON('users.json');
        
        if($users)
        {
            if($users->tipo=="cliente")
            {

               $response=$users->email;
            }
        }
        return $response;
     }


 }