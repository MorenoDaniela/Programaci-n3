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
        $arrayJson= Archivos::leerJSON($archivo);

        
        if (is_null($arrayJson))
        {
            $arrayJson = array();
        }
        array_push($arrayJson, $objeto);
        
        
        // ESCRIBIMOS

        $file = fopen($archivo, 'w');

        $rta = fwrite($file, json_encode($arrayJson));
        //var_dump($arrayJson);

        fclose($file);

        return $rta;
    }

    public static function reemplazarJSON($archivo,$objeto)
    {
        

        $file = fopen($archivo, 'w');

        $rta = fwrite($file, json_encode($objeto));
        //var_dump($arrayJson);

        fclose($file);

        return $rta;
    }

    public static function leerJSON($archivo)
    {
        $file = fopen($archivo, 'r');
       
        $arrayString = fread($file, filesize($archivo));

        $arrayJSON = json_decode($arrayString);

        fclose($file);

        return $arrayJSON;
    }

    public static function MarcaAgua($pathOriginal, $pathDestino)
    {
        // Cargar la estampa y la foto para aplicarle la marca de agua
    $im = imagecreatefromjpeg($pathOriginal);

    // Primero crearemos nuestra imagen de la estampa manualmente desde GD
    $estampa = imagecreatetruecolor(100, 70);
    imagefilledrectangle($estampa, 0, 0, 99, 69, 0x0000FF);
    imagefilledrectangle($estampa, 9, 9, 90, 60, 0xFFFFFF);
    $im = imagecreatefromjpeg($pathOriginal);
    imagestring($estampa, 5, 20, 20, 'D.Moreno', 0x0000FF);
    imagestring($estampa, 3, 20, 40, '2020', 0x0000FF);

    // Establecer los márgenes para la estampa y obtener el alto/ancho de la imagen de la estampa
    $margen_dcho = 10;
    $margen_inf = 10;
    $sx = imagesx($estampa);
    $sy = imagesy($estampa);

    // Fusionar la estampa con nuestra foto con una opacidad del 50%
    imagecopymerge($im, $estampa, imagesx($im) - $sx - $margen_dcho, imagesy($im) - $sy - $margen_inf, 0, 0, imagesx($estampa), imagesy($estampa), 50);

    // Guardar la imagen en un archivo y liberar memoria
    imagepng($im, $pathDestino);
    imagedestroy($im);
    }
    
}