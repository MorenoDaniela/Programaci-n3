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
        $file = fopen($archivo, 'r');
        $arrayString = fread($file, filesize($archivo));
        $arrayJSON = json_decode($arrayString);
        fclose($file);
        return $arrayJSON;
    }

    public static function guardarJSON($archivo, $objeto)//sin probar
    {
        $file = fopen($archivo, 'r');
        $arrayString = fread($file, filesize($archivo));
        $arrayJson = json_decode($arrayString);
        if ($arrayJson!=false)
        {
            fclose($file);
            $arrayJson = array();
            array_push($arrayJson, $objeto);
            $file = fopen($archivo, 'w');
            $rta = fwrite($file, json_encode($arrayJson));
        }
        fclose($file);
        return $rta;
    }
}