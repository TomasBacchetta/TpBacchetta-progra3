<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
use \App\Models\mesa as mesa;



class MesaController {


    public function CargarUno($request, $response, $args){
        
        $mesaNueva = new mesa();

        $mesaNueva->estado = "Cerrada";
        
        $mesaNueva->save();

        $payload = json_encode(array("mensaje" => "Mesa cargada con éxito"));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        
        $mesa = mesa::where("id", $id)->first();
        $payload = json_encode($mesa);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $mesas = mesa::all();
        $payload = json_encode(array("listaMesas" => $mesas));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();
        $id = $args["id"];
        $estado = $param["estado"];
        $mesaACerrar = mesa::where("id", $id)->first();
        $mesaACerrar->estado = $estado;
        
        $mesaACerrar->save();

        $payload = json_encode(array("Mensaje" => "Estado de mesado pasado a: " . $estado));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }


    public function BorrarUno($request, $response, $args){

        $id = $args["id"];
        

        $mesaABorrar = mesa::where("id", $id)->first();
        

        $mesaABorrar->delete();

        $payload = json_encode(array("mensaje"=> "Mesa eliminada exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    

    

}



?>