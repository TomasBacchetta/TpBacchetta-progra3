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
use \App\Models\empleado as empleado;
use \App\Models\registro as registro;
use GuzzleHttp\Psr7\Stream;
use Http\Factory\Guzzle\StreamFactory;


class PedidoController {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $id_empleado = AutentificadorJWT::ObtenerId($token);
        $pedidoNuevo = new Pedido();

        $pedidoNuevo->mesa_id = $param["mesa_id"];
        $pedidoNuevo->mozo_id = $id_empleado;
    
        $pedidoNuevo->estado = "Abierto";
        

        $pedidoNuevo->save();

        $id = $pedidoNuevo->id;

        //imagen
        if (!file_exists('FotosMesas/')) {
            mkdir('FotosMesas/', 0777, true);
        }
        $destino = "FotosMesas/" . $id . "@" . $param["mesa_id"] . "-" . $_FILES["archivo"]["name"];
        move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino);

    
        //actualizando estado de la mesa
        $mesa = mesa::where("id", $pedidoNuevo->mesa_id)->first();
        $mesa->estado = "Con cliente esperando pedido";

        $mesa->save();

        $pedidoNuevo->foto_mesa = $destino;
        $pedidoNuevo->save();

        registro::CrearRegistro($id_empleado, "Creo pedido");

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
        $pedidos = pedido::orderBy("updated_at", "desc")->get();
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
        $pedidoModificado->estado = $param["estado"];
        

        $pedidoModificado->save();
        


        $payload = json_encode(array("mensaje" => "Pedido modificado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }


    public function BorrarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $id = $args["id"];
        

        $pedidoBorrado = pedido::where("id", $id)->first();
        orden::BorrarTodasLasOrdenesDeUnPedido($id);

        $pedidoBorrado->delete();
        
        $payload = json_encode(array("mensaje"=> "Pedido con id: " . $id . "eliminado exitosamente junto a todas sus ordenes"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function CrearCsv($request, $response, $args){
        $data = pedido::withTrashed()->get();
        $csv = fopen('php://memory', 'w');
        
        foreach ($data as $row) {
	        fputcsv($csv, $row->toArray(), ';');
        }

        $stream = new Stream($csv);
        rewind($csv);

        return $response->withHeader('Content-Type', 'application/force-download')
                        ->withHeader('Content-Type', 'application/octet-stream')
                        ->withHeader('Content-Type', 'application/download')
                        ->withHeader('Content-Description', 'File Transfer')
                        ->withHeader('Content-Transfer-Encoding', 'binary')
                        ->withHeader('Content-Disposition', 'attachment; filename="pedidos.csv"')
                        ->withHeader('Expires', '0')
                        ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                        ->withHeader('Pragma', 'public')
                        ->withBody($stream); 
        

        
        
    }


    public function ImportarCsv($request, $response, $args){
        $tmpName = $_FILES['csv']['tmp_name'];
        $csvAsArray = array_map('str_getcsv', file($tmpName));
        
        foreach ($csvAsArray as $eObj){
            $pedido = new pedido();
            $array = explode(';', $eObj[0]);
            if (!pedido::existePedido_PorId($array[0])){
                $pedido->id = $array[0];
                $pedido->mesa_id = $array[1];
                $pedido->mozo_id = $array[2];
                $pedido->total = $array[3];
                $pedido->tiempo_estimado = $array[4];
                $pedido->estado = $array[5];
                $pedido->foto_mesa = $array[6];
                $pedido->created_at = $array[7];
                $pedido->updated_at = $array[8];

                
            } else {
                
                $pedido = pedido::where("id", $array[0])->withTrashed()->first();
                if ((!isset($pedido->deleted_at) || $pedido->deleted_at != '') &&
                    ($array[9] == null || $array[9] == '')){
                    $pedido->deleted_at = null;
                    orden::RestaurarTodasLasOrdenesDeUnPedido($array[0]);
                }

                
            }

                $pedido->save();
            

        }
        

        $payload = json_encode(array("mensaje" => "Csv importado con exito"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
    }

    /*
    public function CrearPDF($request, $response, $args){
        $id = $args["id"];
        $pedido = pedido::where("id", $id)->first();
        $ordenes = orden::where("pedido_id", $id)->get();
        $mozo = empleado::where("id", $pedido->mozo_id)->first();

        $textoOrdenes = "<dl>";

        foreach ($ordenes as $eOrden){
            $producto = producto::where("id", $eOrden->producto_id)->first();
            $textoOrdenes .= '<dt> x' . $eOrden->cantidad . ' ' . $producto->descripcion . '-------$' . $producto->precio . '</dt>';
            $textoOrdenes .= '<dd>Subtotal: $' . $eOrden->subtotal . '</dd>';
        }

        $textoOrdenes .= "</dl>";


        
        $pdf = new TCPDF('P', 'mm', 'A5', true, 'UTF-8', false, true);
    
        $pdf->addPage();
        $texto = '<img src="./logo/logo.png" alt="test alt attribute" width="60" height="60" border="0" />
                    <h1>Factura</h1> <br>
                    Fecha: ' . date("y-m-d") . '<br>
                    Pedido N°: ' . $id . '<br>
                    Mesa N°: ' . $pedido->mesa_id .'<br> 
                    Mozo: ' . $mozo->nombre .'<br> 
                    <ol>
                        
                        
                        
                    ' . $textoOrdenes . '<br><br> Total:$' . $pedido->total;
                    $pdf->writeHTML($texto, true, false, true, false, '');

        
        ob_end_clean();
        $pdf->Output($id . '.pdf', 'I');
        
        return $response->withHeader("Content-Type", "application/pdf");
    
    }
    */

    public function CrearPDF($request, $response, $args){
        $id = $args["id"];
        
        pedido::CrearFacturaPDF($id)->Output($id . '.pdf', 'I');
        
        return $response->withHeader("Content-Type", "application/pdf");
    
    }

    

}



?>