<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
use \App\Models\encuesta as encuesta;
use GuzzleHttp\Psr7\Stream;


class encuestaController {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        $pedido_id = AutentificadorJWT_Clientes::ObtenerIdPedido($token);
        $encuesta_mesa = $param["encuesta_mesa"];
        $encuesta_restaurante = $param["encuesta_restaurante"];
        $encuesta_mozo = $param["encuesta_mozo"];
        $encuesta_cocinero = $param["encuesta_cocinero"];
        $encuesta_cervecero = $param["encuesta_cervecero"];
        $encuesta_bartender = $param["encuesta_bartender"];
        $pedicomentariodo_id = $param["comentario"];
        
        

        $encuestaNueva = new encuesta();
        $encuestaNueva->pedido_id = $pedido_id;
        $encuestaNueva->encuesta_mesa = $encuesta_mesa;
        $encuestaNueva->encuesta_restaurante = $encuesta_restaurante;
        $encuestaNueva->encuesta_mozo = $encuesta_mozo;
        $encuestaNueva->encuesta_cocinero = $encuesta_cocinero;
        $encuestaNueva->encuesta_cervecero = $encuesta_cervecero;
        $encuestaNueva->encuesta_bartender = $encuesta_bartender;
        $encuestaNueva->pedicomentariodo_id = $pedicomentariodo_id;
   
        
        $encuestaNueva->save();

        $payload = json_encode(array("mensaje" => "Encuesta generada"));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        $encuesta = encuesta::where('id', $id)->first();
        $payload = json_encode($encuesta);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $encuestas = encuesta::all();
        $payload = json_encode(array("listaUsuario" => $encuestas));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function ModificarUno($request, $response, $args){
        $id = $args["id"];
        $param = $request->getParsedBody();

        $pedido_id = $param["pedido_id"];
        $encuesta_mesa = $param["encuesta_mesa"];
        $encuesta_restaurante = $param["encuesta_restaurante"];
        $encuesta_mozo = $param["encuesta_mozo"];
        $encuesta_cocinero = $param["encuesta_cocinero"];
        $encuesta_cervecero = $param["encuesta_cervecero"];
        $encuesta_bartender = $param["encuesta_bartender"];
        $pedicomentariodo_id = $param["comentario"];

        $encuestaAModificar = encuesta::where('id', $id)->first();
        $encuestaAModificar->pedido_id = $pedido_id;
        $encuestaAModificar->encuesta_mesa = $encuesta_mesa;
        $encuestaAModificar->encuesta_restaurante = $encuesta_restaurante;
        $encuestaAModificar->encuesta_mozo = $encuesta_mozo;
        $encuestaAModificar->encuesta_cocinero = $encuesta_cocinero;
        $encuestaAModificar->encuesta_cervecero = $encuesta_cervecero;
        $encuestaAModificar->encuesta_bartender = $encuesta_bartender;
        $encuestaAModificar->pedicomentariodo_id = $pedicomentariodo_id;

        $encuestaAModificar->save();

        $payload = json_encode(array("mensaje" => "Usuario modificado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function BorrarUno($request, $response, $args){

        $id = $args["id"];

        $empleadoABorrar = encuesta::where("id", $id);
        
        $empleadoABorrar->delete();

        $payload = json_encode(array("mensaje"=> "Usuario eliminado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function CrearCsv($request, $response, $args){

        
        $data = encuesta::all();
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
                        ->withHeader('Content-Disposition', 'attachment; filename="encuestas.csv"')
                        ->withHeader('Expires', '0')
                        ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                        ->withHeader('Pragma', 'public')
                        ->withBody($stream);
        

        
        
    }


    public function ImportarCsv($request, $response, $args){
        $tmpName = $_FILES['csv']['tmp_name'];
        $csvAsArray = array_map('str_getcsv', file($tmpName));
        var_dump($csvAsArray);
        
        foreach ($csvAsArray as $eObj){
            $mesa = new encuesta();
            $array = explode(';', $eObj[0]);
            if (!encuesta::existeEncuesta_PorId($array[0])){
                encuesta::where("id", $array[0])->forceDelete();//esto es por si hay un id con softdelete, la prioridad la tiene el csv
                $mesa->id = $array[0];
                $mesa->pedido_id = $array[1];
                $mesa->calificacion_mesa = $array[2];
                $mesa->calificacion_restaurante = $array[3];
                $mesa->calificacion_mozo = $array[4];
                $mesa->calificacion_cocinero = $array[5];
                $mesa->calificacion_cervecero = $array[6];
                $mesa->calificacion_bartender = $array[7];
                $mesa->comentario = $array[8];
                $mesa->created_at = $array[9];
                $mesa->updated_at = $array[10];
                

                $mesa->save();
            }
            

        }
        

        $payload = json_encode(array("mensaje" => "Csv importado con exito"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
    }

    

}



?>