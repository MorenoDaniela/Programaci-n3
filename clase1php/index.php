<?php

    include './funciones.php';
    include './persona.php';

    $nombre = "Daniela";
    
    echo strlen("$nombre");
    echo "</br>";//salto de linea
    echo "Hola $nombre";

    $array = array (1,"cadena",1.2);
    echo "</br>";
    var_dump($array);//muestra el array entero
    echo "</br>";
    var_dump($array[1]);//muestra el indice que le especifico

    foreach($array as $value)
    {
      echo "$value <br>";
    }

    /*
    saludarNombre($nombre);*/

    $persona = new Persona('Juan');
    echo $persona->saludar();
    
  ?>