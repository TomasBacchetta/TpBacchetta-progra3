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



class encuestaController {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $pedido_id = $param["pedido_id"];
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

    

}



?>