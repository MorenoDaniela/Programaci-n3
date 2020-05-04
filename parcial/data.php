<?php
class Data
{
    public static function save($file,$object)
    {
        $response=false;

        $pFile = fopen($file,'a+');
        if ($pFile != null)
        {
            $rta = fwrite($pFile,serialize($object). PHP_EOL);
            if ($rta>0)
            {
                $response = true;
            }
            fclose($pFile);        
        }
          
        return $response;
    }

    public static function load($file)
    {
        $response=false;

        $pFile = fopen($file,'r');
        if ($pFile != null)
        {
            $response = array();
            
            while (!feof($pFile))
            {
                array_push($response,unserialize(fgets($pFile)));
            } 
            array_pop($response);
            fclose($pFile); 
        }
          
        return $response;
    }


    public static function LOADD($file)
    {
        $response=false;

        $pFile = fopen($file,'r');
        if ($pFile != null)
        {
            $response = array();
            
            while (!feof($pFile))
            {
                $rta = fgets($pFile);
                $explode= explode(' ',$rta);
                if (count($explode)>1)
                {
                    array_push($response,unserialize($explode));
                }
            } 
            array_pop($response);
            fclose($pFile); 
        }
          
        return $response;
    }

}


/*
<?php

class Data{

    public static function Save($file,$object){

        $response = false;
        $pFile = fopen($file,'a+');
        if(!is_null($pFile)){
            $rta = fwrite($pFile,serialize($object).PHP_EOL);
            if($rta > 0){
                $response = true;
            }
            fclose($pFile);
        }
        return $response;
    }

    public static function Load($file){
        $pFile = fopen($file,'r');
        $response = false;
        if(!is_null($pFile)){
            $response = array();
            while(!feof($pFile)){
                $var = fgets($pFile);
                array_push($response,unserialize($var));
            }           
            fclose($pFile);
            array_pop($response);
        }

        return $response;
    }

}*/
