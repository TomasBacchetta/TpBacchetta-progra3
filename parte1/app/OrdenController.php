<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
include_once "Orden.php";
include_once "Producto.php";
include_once "Pedido.php";


class OrdenController extends Orden {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $ordenNueva = new Orden();
        $ordenNueva->num_pedido = $param["num_pedido"];
        $ordenNueva->num_producto = $param["num_producto"];
        $ordenNueva->cantidad = $param["cantidad"];
        
        $producto = Producto::obtenerProducto($ordenNueva->num_producto);

        $ordenNueva->descripcion = $producto->descripcion;
        $ordenNueva->subtotal = $producto->precio * $ordenNueva->cantidad;
        $ordenNueva->tiempo_estimado = $producto->tiempo_estimado;
        $ordenNueva->estado = "Iniciada";
        
        $ordenNueva->crearOrden();

        //actualizando producto

        $producto->stock -= $ordenNueva->cantidad;

        $producto->modificarProducto();
    
        

        //actualizando pedido (la orden nueva condiciona al pedido)
        
        $pedidoActualizado = Pedido::obtenerPedido($ordenNueva->num_pedido);

     
        $pedidoActualizado->total = Orden::obtenerMontoTotalDeOrdenesPorNumPedido($ordenNueva->num_pedido);
        $pedidoActualizado->tiempo_estimado = Orden::obtenerTiempoEstimadoMayorPorNumPedido($ordenNueva->num_pedido);
        $pedidoActualizado->estado = "Con orden";

        $pedidoActualizado->modificarPedido();


        $payload = json_encode(array("mensaje" => "Orden cargada con éxito en pedido " . $ordenNueva->num_pedido));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $num_orden = $args["num_orden"];
        $orden = Orden::obtenerOrden($num_orden);
        $payload = json_encode($orden);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerOrdenesPorNum_pedido($request, $response, $args){
        $num_pedido = $args["num_pedido"];
        $ordenes = Orden::obtenerOrdenesPorNumPedido($num_pedido);
        $payload = json_encode(array("listaOrdenes" => $ordenes));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function TraerTodos($request, $response, $args){
        $ordenes = Orden::obtenerOrdenes();
        $payload = json_encode(array("listaOrdenes" => $ordenes));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $param = $request->getParsedBody();
        $ordenModificada = new Orden();
        $ordenModificada->num_orden = $param["num_orden"];
        $ordenModificada->num_pedido = $param["num_pedido"];
        $ordenModificada->num_producto = $param["num_producto"];
        $ordenModificada->cantidad = $param["cantidad"];        
        $ordenModificada->calificacion_empleado = $param["calificacion_empleado"];        
        
        $producto = Producto::obtenerProducto($ordenModificada->num_producto);
        $ordenModificada->descripcion = $producto->descripcion;
        $ordenModificada->subtotal = $producto->precio * $ordenModificada->cantidad;
        //$ordenModificada->tiempo_estimado = $producto->tiempo_estimado;
        

        $ordenModificada->modificarOrden();

        $payload = json_encode(array("mensaje" => "Orden modificada exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function BorrarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $num_orden = $param["num_orden"];
        

        $ordenBorrada = new Orden();
        $ordenBorrada->id_producto = $num_orden;
        

        $ordenBorrada->borrarOrden();

        $payload = json_encode(array("mensaje"=> "Orden eliminada exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function CambiarEstado($request, $response, $args){
        $num_orden = $args["num_orden"];
        $param = $request->getParsedBody();
        $estado = $param["estado"];

        $orden = Orden::obtenerOrden($num_orden);
        $orden->estado = $estado;
        

        $pedido = Pedido::obtenerPedido($orden->num_pedido);

        switch ($estado){
            case "en_preparacion":
                $orden->tiempo_inicio = date("Y-m-d H:i:s"); 
                break;
            case "preparada":
                
                break;
        }

        $orden->modificarOrden();

        $payload = json_encode(array("mensaje"=> "Estado de orden cambiado a " . $estado));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
    }

    /*
    estados:
    -Iniciada (automático al crear el pedido)
    -En preparacion (cambiado por el empleado correspondiente)
    -Preparada

*/
    
    

    

}



?>