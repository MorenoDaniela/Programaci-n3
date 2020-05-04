<?php
include_once 'archivos.php';
include_once 'ventas.php';

class Producto
{
    public $producto;
    public $marca;
    public $stock;
    public $precio;
    public $foto;
    public $id;

    public function __construct($producto, $marca, $stock, $precio, $foto, $id)
    {
        $this->producto = $producto;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->foto = $foto;
        $this->id = $id;
    }

    

    public static function CrearVenta($id, $cantidad, $usuario)
    {
        $return = false;
        $array = Archivos::leerJson('productos.json');
        $ultimo = 'El id ingresado no es correcto';
        $nuevoArray='';
        $newPrecio='';

        foreach ($array as $product)
        {
            if ($product->id == $id && $product->stock >= $cantidad)
            {
                
                //$newProducto = $product->producto;//nombre
                //$newId = $product->id;//id
                //$newMarca = $product->marca;//marca
                //$stock = $product->stock - $cantidad;//nueva cantidad
                $product->stock = $product->stock - $cantidad;
                $newPrecio = $product->precio;//precio
                //$newFoto = $product->foto;//foto

                $ultimo = $product->precio * $cantidad;

                //unset($product->stock);
                //$nuevo = new Producto($newProducto,$newMarca,$stock,$newPrecio,$newFoto,$newId);
                //array_push($array,$nuevo);

               

            }
            $nuevoArray=$array;
            
        }
        Archivos::reemplazarJSON('productos.json',$nuevoArray);
                $venta = new Ventas($id,$cantidad, $newPrecio, $usuario);
                if (Data::SerializarObjeto('ventas.txt',$venta))
                {
                    $return = $ultimo;
                }

                
        return $return;
    }

}