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
use GuzzleHttp\Psr7\Stream;

class OrdenController {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        $ordenNueva = new Orden();
        $ordenNueva->pedido_id = $param["pedido_id"];
        $ordenNueva->producto_id = $param["producto_id"];
        $ordenNueva->empleado_id = AutentificadorJWT::ObtenerId($token);
        $ordenNueva->cantidad = $param["cantidad"];
        
       
        $producto = producto::where("id", $ordenNueva->producto_id)->first();

        $ordenNueva->descripcion = $producto->descripcion;
        $ordenNueva->subtotal = $producto->precio * $ordenNueva->cantidad;
        $ordenNueva->tiempo_estimado = $producto->tiempo_estimado;
        $ordenNueva->estado = "Abierta";
        
        $ordenNueva->save();

        //actualizando producto

        $producto->stock -= $ordenNueva->cantidad;

        $producto->save();
    
        
        //actualizando pedido (la orden nueva condiciona al pedido)
        
        $pedidoActualizado = pedido::where("id", $ordenNueva->pedido_id)->first();
        $pedidoActualizado->total = orden::where("pedido_id", $ordenNueva->pedido_id)->sum("subtotal");
        $pedidoActualizado->tiempo_estimado = orden::where("pedido_id", $ordenNueva->pedido_id)->max("tiempo_estimado");
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
        $ordenes = orden::orderBy("pedido_id", "desc");
        $payload = json_encode(array("listaOrdenes" => $ordenes));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();
        

        $ordenModificada = new Orden();
        $ordenModificada->pedido_id = $param["pedido_id"];
        $ordenModificada->producto_id = $param["producto_id"];

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
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $ordenModificada = orden::where("id", $id)->first();
        $ordenModificada->estado = $param["estado"];
        

        $ordenModificada->save();

        $pedido_id = orden::where("id", $id)->value("pedido_id");

        if ($ordenModificada->estado == "En preparacion"){
            //el empleado idoneo toma una orden Abierta y la cambia a "en preparancion
            //si esta fue la ultima orden que se necesitaba preparar para el pedido
            //vinculado, el pedido pasa a estar En Preparacion
            //ademas, la orden pasa a estar vinculada al empleado

            $ordenModificada->empleado_id = AutentificadorJWT::ObtenerId($token);
            $ordenModificada->save();
            $ordenes = orden::ObtenerOrdenesAbiertasPorPedido($pedido_id);
            if (!$ordenes){//si todas las ordenes vinculadas al pedido ya se encuentran  en preparacion preparadas
                $pedido = pedido::where("id", $pedido_id)->first();
                $pedido->estado = "En preparacion";
                $pedido->save();
            }
            
        }
        

        if ($ordenModificada->estado == "Listo para servir"){
            //el empleado idoneo toma una orden En Preparacion y la cambia a Preparada
            //si esta fue la ultima orden que se necesitaba preparar para el pedido
            //vinculado, el pedido pasa a estar En Preparacion
            
            $ordenes = orden::ObtenerOrdenesAbiertasPorPedido($pedido_id);
            if (!$ordenes){//si ya no hay ordenes abiertas
                $pedido = pedido::where("id", $pedido_id)->first();
                $pedido->estado = "Listo para servir";
                $pedido->save();
            }
            
        }

        
        


        $payload = json_encode(array("mensaje" => "Estado de la orden cambiado a " . $param["estado"]));

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

    public function CrearCsv($request, $response, $args){

        
        $data = orden::all();
        if (!file_exists('backup/')) {
            mkdir('backup/', 0777, true);
        }
        $csv = fopen('./backup/ordenes.csv', 'w');

        
        foreach ($data as $row) {
	        fputcsv($csv, $row->toArray(), ';');
        }

        fclose($csv);
      

        $file = 'ordenes.csv';
        $fh = fopen('./backup/' . $file, 'rb');

        $stream = new Stream($fh); // create a stream instance for the response body

        return $response->withHeader('Content-Type', 'application/force-download')
                        ->withHeader('Content-Type', 'application/octet-stream')
                        ->withHeader('Content-Type', 'application/download')
                        ->withHeader('Content-Description', 'File Transfer')
                        ->withHeader('Content-Transfer-Encoding', 'binary')
                        ->withHeader('Content-Disposition', 'attachment; filename="' . basename($file) . '"')
                        ->withHeader('Expires', '0')
                        ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                        ->withHeader('Pragma', 'public')
                        ->withBody($stream); // all stream contents will be sent to the response
        

        
        
    }


    public function ImportarCsv($request, $response, $args){
        $tmpName = $_FILES['csv']['tmp_name'];
        $csvAsArray = array_map('str_getcsv', file($tmpName));
        var_dump($csvAsArray);
        
        foreach ($csvAsArray as $eObj){
            $pedido = new orden();
            $array = explode(';', $eObj[0]);
            if (!orden::existeOrden_PorId($array[0])){
                orden::where("id", $array[0])->forceDelete();//esto es por si hay un id con softdelete, la prioridad la tiene el csv
                $pedido->id = $array[0];
                $pedido->pedido_id = $array[1];
                $pedido->producto_id = $array[2];
                $pedido->empleado_id = $array[3];
                $pedido->descripcion = $array[4];
                $pedido->cantidad = $array[5];
                $pedido->subtotal = $array[6];
                $pedido->tiempo_inicio = $array[7];
                $pedido->tiempo_estimado = $array[8];
                $pedido->estado = $array[9];
                $pedido->created_at = $array[10];
                $pedido->updated_at = $array[11];

                $pedido->save();
            }
            

        }
        

        $payload = json_encode(array("mensaje" => "Csv importado con exito"));

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