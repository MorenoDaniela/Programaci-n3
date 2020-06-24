<?php
class Datos
{
    public static function SerializarObjeto($file,$object)//deja @ al final cuando guarda
    {
        $response= false;
        $pFile = fopen($file,'a+');
        if ($pFile!=false || $pfile!=null)
        {
            $rta = fwrite($pFile,serialize($object). '@');
            if ($rta>0)
            {
                $response=true;
            }
        }
        fclose($pFile);
        return $response;
    }

    public static function DeserializarObjeto($file)//recordar que al traer en el foreach mirar que el objeto no sea @
    {
        $response=false;
        $pFile=fopen($file,'r');
        if ($pFile!=false)
        {
            $serializado=fread($pFile,filesize($file));
            $var=explode('@',$serializado);
            $array = array();
            foreach ($var as $string)
            {
                $object = unserialize($string);
                if ($object != false)
                {
                    array_push($array,$object);
                }
            }
            $response=$array;
        }
        fclose($pFile);
        return $response;
    }

    public static function GuardarTxt($file,$object)//guarda con PHP_EOL al final
    {
        $response=false;
        $pFile = fopen($file,'a+');
        if ($pFile != null)
        {
            $rta = fwrite($pFile,serialize($object). PHP_EOL);
            var_dump($rta);
            if ($rta>0)
            {
                $response = true;
            }        
        }
        fclose($pFile);   
        return $response;
    }

    public static function TraerTxt($file)//recordar al traer verificar que el object no sea un PHP_EOL en foreach
    {
        $pFile = fopen($file,'r');
        $response = false;
        if(!is_null($pFile))
        {
            $response = array();
            while(!feof($pFile))
            {
                $var = fgets($pFile);
                array_push($response,unserialize($var));
            }           
            
            array_pop($response);
        }
        fclose($pFile);

        return $response;
    }

    public static function TraerJSON($archivo)//sin probar
    {
        $file = fopen($archivo, 'a+');//cambiar a r y dejar lo de abajo si tira error fread
        if(filesize($archivo)!=0)
        {
            $arrayString = fread($file, filesize($archivo));
            $arrayJSON = json_decode($arrayString);
            fclose($file);
            return $arrayJSON;
        }else{
            return NULL;
        }
        /*
        $arrayString = fread($file, filesize($archivo));
        $arrayJSON = json_decode($arrayString);
        fclose($file);
        return $arrayJSON;*/
    }

    public static function guardarJSON($archivo, $objeto)//sin probar
    {
        $arrayJson= Datos::TraerJSON($archivo);
        if (is_null($arrayJson))
        {
            $arrayJson = array();
        }
        array_push($arrayJson, $objeto);
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