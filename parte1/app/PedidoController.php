<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
require_once "Pedido.php";
require_once "Orden.php";


class PedidoController extends Pedido {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $pedidoNuevo = new Pedido();
        $pedidoNuevo->num_mesa = $param["num_mesa"];
        $pedidoNuevo->num_mozo = $param["num_mozo"];
    
        $pedidoNuevo->fecha_pedido = date("y-m-d");
        $pedidoNuevo->estado = "Abierto";
    
        
        $id = $pedidoNuevo->crearPedido();

        //imagen
        if (!file_exists('FotosMesas/')) {
            mkdir('FotosMesas/', 0777, true);
        }
        $destino = "FotosMesas/" . $id . "@" . $_FILES["archivo"]["name"];
        move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino);

        $pedidoActualizado = new Pedido();

        foreach (get_object_vars(Pedido::obtenerPedido($id)) as $key => $value) {
            $pedidoActualizado->$key = $value;
        }
        $pedidoActualizado->foto_mesa = $destino;
        $pedidoActualizado->modificarPedido();

        
        $payload = json_encode(array("mensaje" => "Pedido cargado con éxito con id: " . $id));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $num_pedido = $args["num_pedido"];
        $pedido = Pedido::obtenerPedido($num_pedido);
        $ordenesDelPedido = Orden::obtenerOrdenesPorNumPedido($num_pedido);
        $jsonPedido = json_encode($pedido);   
        $jsonOrdenesDelPedido = json_encode($ordenesDelPedido);
        $arrayCombinado = array("pedido" => json_decode($jsonPedido, true),
                        "ordenes" => json_decode($jsonOrdenesDelPedido, true)
        );
        
        $payload = json_encode($arrayCombinado, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }


    public function TraerTodos($request, $response, $args){
        $pedidos = Pedido::obtenerPedidos();
        $arrayPedidos = array();
        foreach ($pedidos as $ePedido){
             $ordenesDelPedido = Orden::obtenerOrdenesPorNumPedido($ePedido->num_pedido);
            $jsonPedido = json_encode($ePedido);  
            $jsonOrdenesDelPedido = json_encode($ordenesDelPedido);
            $arrayCombinado = array("pedido" => json_decode($jsonPedido, true),
                        "ordenes" => json_decode($jsonOrdenesDelPedido, true)
        );
        array_push($arrayPedidos, $arrayCombinado);
        }
        
        
        
        $payload = json_encode($arrayPedidos, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $param = $request->getParsedBody();
        $ordenModificada = new Producto();
        $ordenModificada->num_orden = $param["num_orden"];
        $ordenModificada->num_pedido = $param["num_pedido"];
        $ordenModificada->num_producto = $param["num_producto"];
        $ordenModificada->cantidad = $param["cantidad"];

        $producto = Producto::obtenerProducto($ordenModificada->num_producto);
        $ordenModificada->descripcion = $producto->descripcion;
        $ordenModificada->subtotal = $producto->precio * $ordenModificada->cantidad;
        $ordenModificada->tiempo_estimado = $producto->tiempo_estimado;
        

        //$ordenModificada->modificarOrden();

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

    
    

    

}



?>