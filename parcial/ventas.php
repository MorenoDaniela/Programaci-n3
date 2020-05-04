<?php
include_once 'data.php';

class Ventas
{
    public $id;
    public $precio;
    public $comprador;
    public $cantidad;


    public function __construct($id ,$cantidad, $precio,$comprador)
    {
        $this->id = $id;
        $this->precio = $precio;
        $this->comprador = $comprador;
        $this->cantidad = $cantidad;
    }

    public static function MostrarVentas()
    {
        $response = Data::load("ventas.txt");
        return $response;
    }

    public static function MostrarVentasUser($nombre)
    {
        $return = false;
        $response = Data::load("ventas.txt");
        //var_dump($response);
        $array = array();
        foreach ($response as $users)
        {
            if ($users->comprador == $nombre)
            {
                array_push($array,$users);
                //$return = $return . $users;
                $return = $array;
            }
        }
        return $return;
    }


}