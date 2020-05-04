<?php
/**
 * METODOS PHP
 * GET: Obtener recursos
 * POST: Crear recursos
 * PUT: Modificar recursos
 * DELETE: Borrar recursos
 */
include_once './persona.php';
include_once './animal.php';
include_once './archivos.php';
include_once './response.php';

$respuesta = new Response;
$respuesta->data='';


$requestMethod = $_SERVER['REQUEST_METHOD'];
$pathInfo = $_SERVER['PATH_INFO'];//clase ./persona

switch($pathInfo)
{
    case '/persona':
        
        switch($requestMethod)
        {
            case 'GET':
                
               // $respuesta->data = array('pepe1, pepe2');
                //echo Persona::readPersona();
                if (isset($_GET['id']))
                {
                    //$rta = findPersona($_GET['id'],"personas.json");
                    $rta = Persona::findPersona($_GET['id'],"personas.json");
                    $respuesta->data=$rta;
                }else
                {
                    $respuesta->data = 'Faltan datos';
                    $respuesta->status = 'fail';
                }
                echo json_encode($respuesta);
            break;
            case 'POST':
                //$respuesta->data=array('america, asia');
                if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['edad']) && isset($_POST['id']))
                {
                    $persona = new Persona($_POST['nombre'],$_POST['apellido'],$_POST['edad'],$_POST['id']);
                    $respuesta->data= $persona->savePersona();
                }else
                {
                    $respuesta->data = 'Faltan datos';
                    $respuesta->status = 'fail';
                }
                echo json_encode($respuesta);
            break; 
            case 'PUT':
                echo "hola";
                if (isset($_PUT['id']))
                {
                    $rta = Persona::findPersona($_PUT['id'],"personas.json");
                    if (isset($_PUT['nombre']))
                    {
                        $rta->nombre=$_PUT['nombre'];
                    }if (isset($_PUT['edad']))
                    {
                        $rta->apellido=$_PUT['apellido'];
                    }
                    if ( isset($_PUT['apellido']))
                    {
                        $rta->edad=$_PUT['edad'];
                    }
                    $respuesta->data=$rta->savePersona();
 
                }else
                {
                    $respuesta->data = 'Para modificar se debe ingresar un id';
                    $respuesta->status = 'fail';
                }

                echo json_encode($respuesta);
            break;
            case 'DELETE':
                if (isset($_DELETE['id']))
                {
                    $rta = Persona::findPersona($_DELETE['id'],"personas.json");
                    unlink($rta);
 
                }else
                {
                    $respuesta->data = 'Para modificar se debe ingresar un id';
                    $respuesta->status = 'fail';
                }

                echo json_encode($respuesta);
                
            break;
            default:
                $respuesta->data = "Metodo no definido";
                $respuesta->status = 'fail';
                echo json_encode($respuesta);
            break;
        }
    break;
    case '/animal':
        switch($requestMethod)
        {
            case 'GET':
                echo "get";
            break;
            case 'POST':
                echo "post";      
            break;
            case 'PUT':
                //$respuesta->data=array('Latinoamerica, Northamerica');
                echo "put";
            break;
            case 'DELETE':
                echo "delete";
                //$respuesta->data=array('Latinoamerica, Northamerica');
            break;
            default:
                $respuesta->data = "Metodo no definido";
                $respuesta->status = 'fail';
            break;
        }
    break;
    default:
    $respuesta->data="Path no disponible";
    $respuesta->status = 'fail';
    echo json_encode($respuesta);
    break;
}
/*
if (isset($_GET['name']))
{
    echo $_GET['name'];
}else if(isset($_POST['name']))
{
    echo $_POST['name'];
}else
{
    echo "metodo no disponible";
}*/

//var_dump($_GET);