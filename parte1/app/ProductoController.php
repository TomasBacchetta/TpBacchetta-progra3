<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/


/*
    public $id_producto;
    public $descripcion;
    public $precio;
    public $stock;
    public $sector;
    public $tiempo_estimado;
    
    
*/
require_once "Producto.php";
class ProductoController extends Producto {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $descripcion = $param["descripcion"];
        $precio = $param["precio"];
        $stock = $param["stock"];
        $sector = $param["sector"];
        $tiempo_estimado = $param["tiempo_estimado"];
    
        $productoNuevo = new Producto();
        $productoNuevo->descripcion = $descripcion;
        $productoNuevo->precio = $precio;
        $productoNuevo->stock = $stock;
        $productoNuevo->sector = $sector;
        $productoNuevo->tiempo_estimado = $tiempo_estimado;
        
        $productoNuevo->crearProducto();

        $payload = json_encode(array("mensaje" => "Producto cargado con éxito para ser usado en " . $sector));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id_producto = $args["id_producto"];
        $producto = Producto::obtenerProducto($id_producto);
        $payload = json_encode($producto);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $productos = Producto::obtenerTodos();
        $payload = json_encode(array("listaProductos" => $productos));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $id_producto = $param["id_producto"];
        $descripcion = $param["descripcion"];
        $precio = $param["precio"];
        $stock = $param["stock"];
        $sector = $param["sector"];
        $tiempo_estimado = $param["tiempo_estimado"];

        $productoAModificar = new Producto();
        $productoAModificar->descripcion = $descripcion;
        $productoAModificar->precio = $precio;
        $productoAModificar->stock = $stock;
        $productoAModificar->sector = $sector;
        $productoAModificar->tiempo_estimado = $tiempo_estimado;
        

        $productoAModificar->modificarProducto();

        $payload = json_encode(array("mensaje" => "Producto modificado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function BorrarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $id_producto = $param["id_producto"];
        

        $productoABorrar = new Producto();
        $productoABorrar->id_producto = $id_producto;
        

        $productoABorrar->borrarProducto();

        $payload = json_encode(array("mensaje"=> "Producto eliminado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    

    

    

}



?>