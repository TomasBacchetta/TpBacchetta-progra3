<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
require_once "Mesa.php";



class MesaController extends Mesa{


    public function CargarUno($request, $response, $args){
        
        $mesaNueva = new Mesa();

        
        $mesaNueva->crearMesa();

        $payload = json_encode(array("mensaje" => "Mesa cargada con éxito"));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $numero = $args["numero"];
        $mesa = Mesa::obtenerMesa($numero);
        $payload = json_encode($mesa);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $mesas = Mesa::obtenerTodos();
        $payload = json_encode(array("listaMesas" => $mesas));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }


    public function BorrarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $numero = $param["numero"];
        

        $mesaABorrar = new Mesa();
        $mesaABorrar->numero = $numero;
        

        $mesaABorrar->borrarMesa();

        $payload = json_encode(array("mensaje"=> "Mesa eliminada exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    

    

}



?>