<?php
class Pizza
{
    public $tipo;
    public $precio;
    public $sabor;
    public $stock;
    public $foto;

    public function __construct($tipo, $precio, $stock, $sabor, $foto)
    {
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->sabor=$sabor;
        $this->foto=$foto;
    }

    public static function Singin($tipo, $precio, $stock, $sabor, $foto)
     {
        $return=false;
        $pizza = new Pizza($tipo, $precio, $stock, $sabor, $foto);
        $lista = Datos::TraerJson("pizzas.json");
        if (Pizza::PizzaAlreadyExists($pizza))
        {
            $return = "No se pueden agregar el mismo tipo y sabor de pizza que ya hay en stock.";
        }else
        {
            if (Datos::GuardarJSON("pizzas.json",$pizza))
            {
                $return=true;
            }
        }
        return $return;

        /*
        if (($tipo=='molde' || $tipo=='piedra') && ($sabor=='napo' || $sabor=='muzza' || $sabor=='jamon'))
        {
            if ($lista==false)
            {
                if (Datos::GuardarJSON("pizzas.json",$pizza))
                    {
                        $return=true;
                    }
            }else
            {
                foreach ($lista as $unapizza)
                {
                    if ($unapizza->tipo == $tipo && $unapizza->sabor==$sabor)
                    {
                        $return = "No se pueden agregar el mismo tipo y sabor de pizza que ya hay en stock.";
                    }else
                    {
                        if (Datos::GuardarJSON("pizzas.json",$pizza))
                        {
                            $return=true;
                        }
                    }
                }
            }
            
        }
        return $return;*/
     }

     public static function MostrarPizzas()
     {
         $return = false;
         $lista = Datos::TraerJson("pizzas.json");
         foreach ($lista as $pizza)
         {
             echo "Tipo: {$pizza->tipo}, sabor: {$pizza->sabor}, precio: {$pizza->precio}" . PHP_EOL;
             $return = true;
         }
         return $return;
     }

     public static function PizzaAlreadyExists($pizza)
     {
        $return = false;
        $lista = Datos::TraerJson("pizzas.json");

        if ($lista==true)
        {
            foreach ($lista as $unapizza)
            {
                if ($unapizza->tipo == $pizza->tipo && $pizza->sabor == $unapizza->sabor)
                {
                    $return = true;
                }
            }
        }
        return $return;

     }
}