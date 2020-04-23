<?php
class Archivos
{
    public $archivo;

    public static function save($archivo, $datos)
    {
        $file = fopen($archivo,'a');
        $rta = fwrite($file,$datos);
        fclose($file);
    }

    public static function readAll($archivo)
    {
        $file = fopen($archivo,'r');

        $array = array();

        while (!feof($file))
        {
            $rta= fgets($file);
            $explode=explode('-',$rta);
            //var_dump($explode);
            if (count($explode)  > 1) 
            {
                array_push($array, $explode);
            }
        }
        
        fclose($file);
        return $array;

        /*$file = fopen($archivo,'r');
        $rta = fread($file,filesize($archivo));
        fclose($file);
        return $rta;*/
    }

    

    public static function guardarJSON($archivo, $objeto)
    {
        // LEEMOS
        /*
        $file = fopen($archivo, 'r');

        $arrayString = fread($file, filesize($archivo));

        $arrayJSON = json_decode($arrayString);//encode devuelve json espera recibir un array//decode devuelve array espera recibir un json

        fclose($file);

       // $arrayJSON= array();*/
        $arrayJson= Archivos::leerJSON($archivo);

        if (is_null($arrayJson))
        {
            $arrayJson = array();
        }
        array_push($arrayJson, $objeto);
        
        
        // ESCRIBIMOS

        $file = fopen($archivo, 'w');

        $rta = fwrite($file, json_encode($arrayJson));

        fclose($file);

        return $rta;
    }

    /*
    public static function guardarJSON($archivo, $object){

        $file = fopen($archivo,'r');
        
        $arrayJson = Datos::leerJson($archivo);
        if(is_null($arrayJson)){
            $arrayJson = array();
        }
        array_push($arrayJson,$object);
        fclose($file);

        $file = fopen($archivo,'w');
        fwrite($file,json_encode($arrayJson));
        fclose($file);
        
    }

    public static function leerJson($archivo){

        $file = fopen($archivo,'r');
        $rta = '';    
        while(!feof($file)){
            $linea = json_decode(fgets($file));
            if($rta==''){
                $rta = $linea;
            }else{
                $rta = $rta.' '.$linea;
            }
        
        }
        
        return $rta;

    }*/

    public static function leerJSON($archivo)
    {
        $file = fopen($archivo, 'r');

        $arrayString = fread($file, filesize($archivo));

        $arrayJSON = json_decode($arrayString);

        fclose($file);

        return $arrayJSON;
    }
    
}