<?php
class Persona
{
    public $nombre;


    public function __constructor($nombre)
    {
        $this->nombre=$nombre;
    }

    public function saludar()
    {
        echo "Hola ".$this->nombre;
    }
}