<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
use \App\Models\pedido as pedido;
use \App\Models\orden as orden;
use \App\Models\producto as producto;
use \App\Models\mesa as mesa;


class PedidoController {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $pedidoNuevo = new Pedido();

        $pedidoNuevo->mesa_id = $param["mesa_id"];
        $pedidoNuevo->mozo_id = $param["mozo_id"];
    
        $pedidoNuevo->estado = "Abierto";
    
        
        $pedidoNuevo->save();

        $id = $pedidoNuevo->id;

        //imagen
        if (!file_exists('FotosMesas/')) {
            mkdir('FotosMesas/', 0777, true);
        }
        $destino = "FotosMesas/" . $id . "@" . $_FILES["archivo"]["name"];
        move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino);

        /*
        $pedidoActualizado = new Pedido();

        foreach (get_object_vars(Pedido::obtenerPedido($id)) as $key => $value) {
            $pedidoActualizado->$key = $value;
        }
        
      
        */

        //actualizando estado de la mesa
        $mesa = mesa::where("mesa_id", $pedidoNuevo->mesa_id)->first();
        $mesa->estado = "Con cliente esperando pedido";

        $mesa->save();

        $pedidoNuevo->foto_mesa = $destino;
        $pedidoNuevo->save();

        
        $payload = json_encode(array("mensaje" => "Pedido cargado con éxito con id: " . $id));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        $pedido = pedido::where("id", $id)->first();
        $ordenesDelPedido = orden::where("pedido_id", $pedido->id)->get();
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
        $pedidos = pedido::all();
        $arrayPedidos = array();
        foreach ($pedidos as $ePedido){
            $ordenesDelPedido = orden::where("pedido_id", $ePedido->id)->get();
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
        $id = $args["id"];
        
        $pedidoModificado = pedido::where("id", $id)->first();
        $pedidoModificado->mesa_id = $param["mesa_id"];
        $pedidoModificado->mozo_id = $param["mozo_id"];
        $pedidoModificado->estado = $param["estado"];
        

        $pedidoModificado->save();
        


        $payload = json_encode(array("mensaje" => "Pedido modificado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function CambiarEstado($request, $response, $args){
        $param = $request->getParsedBody();
        $id = $args["id"];
        
        $pedidoModificado = pedido::where("id", $id)->first();
        $pedidoModificado->estado = $param["estado"];
        

        $pedidoModificado->save();
        


        $payload = json_encode(array("mensaje" => "Estado del pedido cambiado a " . $param["estado"] . " exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function BorrarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $id = $args["id"];
        

        $ordenBorrada = orden::where("id", $id)->first();

        $ordenBorrada->delete();
        
        $payload = json_encode(array("mensaje"=> "Orden con id: " . $id . "eliminada exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    
    

    

}



?>