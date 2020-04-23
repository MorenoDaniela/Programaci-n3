<?php
include_once './archivos.php';
class Persona
{
    public $nombre;
    public $apellido;
    public $edad;
    public $id;

    public function __construct($nombre,$apellido,$edad,$id)
    {
        $this->nombre=$nombre;
        $this->apellido=$apellido;
        $this->edad=$edad;
        $this->id=$id;
    }

    public function savePersona()
    {
        //aca llamar a guardar
        //Archivos::save('personas.txt',$this->toFilePersona());
        return Archivos::guardarJSON('personas.json',$this);
    }

    public function toFilePersona()
    {
        return $this->nombre .'-'. $this->apellido .'-'. $this->edad .'-'. $this->id .PHP_EOL;  
    } 
    public static function readPersona()
    {
        return Archivos::readAll('personas.txt');
    }

    public function toJSON()
    {
        return json_encode($this);
    }

    public static function findPersona($id,$archivo)
    {
        
        $array = Archivos::leerJson($archivo);
        $personaEncontrada='Id no encontrado';

            foreach ($array as $value)
            {
                if ($value->id == $id)
                {
                    $personaEncontrada=$value;
                    break;
                }
            }
        
        return $personaEncontrada;
    }
}