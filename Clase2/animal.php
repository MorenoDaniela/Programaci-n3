<?php
include_once './archivos.php';
class Animal
{
    public $name;
    public $tipo;
    public $patas;

    public function __construct ($name,$tipo,$patas)
    {
        $this->name=$name;
        $this->tipo=$tipo;
        $this->patas=$patas;
    }

    public function saveAnimal()
    {
        Guardar::save();
    }

    public function toFileAnimal()
    {
        return $this->name .';'. $this->tipo .';'. $this->patas .';';  
    }

}