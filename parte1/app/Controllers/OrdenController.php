<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
use \App\Models\orden as orden;
use \App\Models\producto as producto;
use \App\Models\pedido as pedido;


class OrdenController {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $ordenNueva = new Orden();
        $ordenNueva->pedido_id = $param["pedido_id"];
        $ordenNueva->producto_id = $param["producto_id"];
        $ordenNueva->empleado_id = $param["empleado_id"];
        $ordenNueva->cantidad = $param["cantidad"];
        
       
        
        $producto = producto::where("id", $ordenNueva->producto_id)->first();

        $ordenNueva->descripcion = $producto->descripcion;
        $ordenNueva->subtotal = $producto->precio * $ordenNueva->cantidad;
        $ordenNueva->tiempo_estimado = $producto->tiempo_estimado;
        $ordenNueva->estado = "Iniciada";
        
        $ordenNueva->save();

        //actualizando producto

        $producto->stock -= $ordenNueva->cantidad;

        $producto->save();
    
        
        //actualizando pedido (la orden nueva condiciona al pedido)
        
        $pedidoActualizado = pedido::where("id", $ordenNueva->pedido_id)->first();
        $pedidoActualizado->total = orden::where("id", $ordenNueva->pedido_id)->sum("subtotal");
        $pedidoActualizado->tiempo_estimado = orden::where("id", $ordenNueva->pedido_id)->max("tiempo_estimado");
        $pedidoActualizado->estado = "Con orden";

        $pedidoActualizado->save();


        $payload = json_encode(array("mensaje" => "Orden cargada con éxito en pedido " . $ordenNueva->num_pedido));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        $orden = orden::where("id", $id)->first();
        $payload = json_encode($orden);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerOrdenesPorPedido_Id($request, $response, $args){
        $pedido_id = $args["pedido_id"];
        $ordenes = orden::where("pedido_id", $pedido_id);
        $payload = json_encode(array("listaOrdenes" => $ordenes));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function TraerTodos($request, $response, $args){
        $ordenes = orden::all();
        $payload = json_encode(array("listaOrdenes" => $ordenes));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();
        

        $ordenModificada = new Orden();
        $ordenModificada->pedido_id = $param["pedido_id"];
        $ordenModificada->producto_id = $param["producto_id"];
        $ordenModificada->empleado_id = $param["empleado_id"];

        //reincorporando stock al producto
        $producto = producto::where("id", $ordenModificada->producto_id)->first();
        $producto->stock += $ordenModificada->cantidad;

        $ordenModificada->cantidad = $param["cantidad"];
        
        
       
        $ordenModificada->descripcion = $producto->descripcion;
        $ordenModificada->subtotal = $producto->precio * $ordenModificada->cantidad;
        $ordenModificada->tiempo_estimado = $producto->tiempo_estimado;
        $ordenModificada->estado = "Iniciada";
        
        $ordenModificada->save();

        //actualizando producto

        $producto->stock -= $ordenModificada->cantidad;

        $producto->save();
    
        
        //actualizando pedido (la orden modificada condiciona al pedido)
        
        $pedidoActualizado = pedido::where("id", $ordenModificada->pedido_id);
        $pedidoActualizado->total = orden::where("id", $ordenModificada->pedido_id)->sum("subtotal");
        $pedidoActualizado->tiempo_estimado = orden::where("id", $ordenModificada->pedido_id)->max("tiempo_estimado");
        $pedidoActualizado->estado = "Con orden";

        $pedidoActualizado->save();

        $payload = json_encode(array("mensaje" => "Orden modificada exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function CambiarEstado($request, $response, $args){
        $param = $request->getParsedBody();
        $id = $args["id"];
        
        $pedidoModificado = pedido::where("id", $id)->first();
        $pedidoModificado->estado = $param["estado"];
        

        $pedidoModificado->save();
        


        $payload = json_encode(array("mensaje" => "Estado de la orden cambiado a " . $param["estado"] . " exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }


    public function BorrarUno($request, $response, $args){
        

        $id = $args["id"];
        
        $ordenABorrar = orden::where("id", $id)->first();
        

        //reincorporando stock al producto
        $producto = producto::where("id", $ordenABorrar->producto_id)->first();
        $producto->stock += $ordenABorrar->cantidad;

        $producto->save();
        
        
       
    
        
        //actualizando pedido (la orden borrada condiciona al pedido)
        
        $pedidoActualizado = pedido::where("id", $ordenABorrar->pedido_id);
        $pedidoActualizado->total = orden::where("id", $ordenABorrar->pedido_id)->sum("subtotal");
        $pedidoActualizado->tiempo_estimado = orden::where("id", $ordenABorrar->pedido_id)->max("tiempo_estimado");
        $pedidoActualizado->estado = "Con orden";

        $pedidoActualizado->save();

       
        $ordenABorrar->delete();
       

        $payload = json_encode(array("mensaje"=> "Orden eliminada exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    /*
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
    */
    /*
    estados:
    -Iniciada (automático al crear el pedido)
    -En preparacion (cambiado por el empleado correspondiente)
    -Preparada

*/
    
    

    

}



?>