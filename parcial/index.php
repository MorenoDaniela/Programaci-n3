<?php

include_once './response.php';
include_once './users.php';
include_once './producto.php';
include_once './ventas.php';
session_start();

//print_r($_SESSION);

$requestMethod = $_SERVER['REQUEST_METHOD'];
$pathInfo = $_SERVER['PATH_INFO'];

$respuesta = new Response;
$respuesta->data='';

switch($requestMethod)
{
    case 'GET':
        switch($pathInfo)
        {
            case '/stock':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isAdmin($token) || !User::isAdmin($token))
                {
                    $respuesta->data = Archivos::leerJson('./productos.json');
                }
                else
                {
                    //$respuesta->data = Archivos::leerJson('productos.json');
                    $respuesta->data = 'Faltan datos';
                    $respuesta->status = 'fail';
                }
                echo json_encode($respuesta);
            break;
            case '/ventas':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isAdmin($token))
                {
                    $respuesta->data= Ventas::MostrarVentas();
                }
                else
                {
                   $nombre = User::notAdmin($token);
                   $respuesta->data = Ventas::MostrarVentasUser($nombre);
                }
                echo json_encode($respuesta);
            break;
        }
    break;
    case 'POST':
        switch($pathInfo)
        {
            case '/login':
                if (isset($_POST['nombre']) && isset($_POST['clave']))
                {
                    $respuesta->data= User::Login($_POST['nombre'],$_POST['clave']);
                }else
                {
                    $respuesta->data = 'Faltan datos';
                    $respuesta->status = 'fail';
                }
                echo json_encode($respuesta);
            break;
            case '/usuario':
                if (isset($_POST['nombre']) && isset($_POST['dni']) && isset($_POST['obra_social']) && isset($_POST['clave']) && isset($_POST['tipo']))
                {
                    //$user = new User();
                    if (User::Singin($_POST['nombre'],$_POST['obra_social'],$_POST['clave'],$_POST['dni'],$_POST['tipo']))
                    {
                        $respuesta->data = 'Sign valido';
                    }
                    
                }else
                {
                    $respuesta->data = 'Faltan datos';
                    $respuesta->status = 'fail';
                }
                echo json_encode($respuesta);
            break;
            case '/stock':
                
                $header = getallheaders();
                $token = $header['token'];
                if (User::isAdmin($token))
                {
                    
                    if (isset($_POST['producto']) && isset($_POST['marca']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_FILES['foto']))
                    {
                        //var_dump($_FILES['foto']);
                        $producto = new Producto($_POST['producto'],$_POST['marca'], $_POST['precio'],$_POST['stock'], $_FILES['foto']['tmp_name'], strtotime("now"));
                        
                        move_uploaded_file($_FILES['foto']['tmp_name'], 'imagenes/'.$_FILES['foto']['name']);

                        $respuesta->data=Archivos::guardarJSON('productos.json',$producto);

                    }else
                    {
                        $respuesta->data='Faltan datos';
                        $respuesta->status='fail';
                    }
                }else
                {
                    $respuesta->data='Error usted no es administrador, token invalido';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            case '/ventas':
                $header = getallheaders();
                $token = $header['token'];
                //echo"hola";
                if (!User::isAdmin($token))
                {
                    if (isset($_POST['id_producto']) && isset($_POST['cantidad']) && isset($_POST['usuario']))
                    {
                        $respuesta->data = Producto::CrearVenta($_POST['id_producto'], $_POST['cantidad'], $_POST['usuario']);
                        
                        if ($respuesta->data == "El id ingresado no es correcto")
                        {
                            $respuesta->status='fail';
                        }
                    }else
                    {
                        $respuesta->data='Faltan datos';
                        $respuesta->status='fail';
                    }
                }else
                {
                    $respuesta->data='Usted no es usuario';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            default:
            $respuesta->data='Error en pathInfo';
            $respuesta->status='fail';
            break;
        }
    break;
    default:
    $respuesta->data='Metodo no permitido';
    $respuesta->status='fail';
    echo json_encode($respuesta);
    break;
}