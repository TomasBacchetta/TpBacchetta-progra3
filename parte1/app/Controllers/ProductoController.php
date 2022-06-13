<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/



use \App\Models\producto as producto;

class ProductoController {


    public function CargarUno($request, $response, $args){
        
        $param = $request->getParsedBody();

        $descripcion = $param["descripcion"];
        $precio = $param["precio"];
        $stock = $param["stock"];
        $sector = $param["sector"];
        $tiempo_estimado = $param["tiempo_estimado"];


        $productoNuevo = new producto();

        $productoNuevo->descripcion = $descripcion; 
        $productoNuevo->precio = $precio; 
        $productoNuevo->stock = $stock; 
        $productoNuevo->sector = $sector; 
        $productoNuevo->tiempo_estimado = $tiempo_estimado; 

        $productoNuevo->save();
    
        

        $payload = json_encode(array("mensaje" => "Producto cargado con éxito para ser usado en " . $sector));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id_producto = $args["id"];
        //otra forma usando instancia
        //$producto = new producto();
        //$producto = $producto->find($id_producto);
        $producto = producto::where('id', '=', $id_producto)->first();
        $payload = json_encode($producto);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $productos = producto::all();
        $payload = json_encode(array("listaProductos" => $productos));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }
   

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $id = $args["id"];
        $descripcion = $param["descripcion"];
        $precio = $param["precio"];
        $stock = $param["stock"];
        $sector = $param["sector"];
        $tiempo_estimado = $param["tiempo_estimado"];

        $productoAModificar = producto::where('id', $id)->first();
        $productoAModificar->descripcion = $descripcion;
        $productoAModificar->precio = $precio;
        $productoAModificar->stock = $stock;
        $productoAModificar->sector = $sector;
        $productoAModificar->tiempo_estimado = $tiempo_estimado;
        

        $productoAModificar->save();

        $payload = json_encode(array("mensaje" => "Producto modificado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function BorrarUno($request, $response, $args){
        $id = $args["id"];
        

        $productoABorrar = producto::where("id", $id)->first();
        $productoABorrar->delete();
        


        $payload = json_encode(array("mensaje"=> "Producto eliminado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    

    

    

}



?>