<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
use \App\Models\admin as admin;
use GuzzleHttp\Psr7\Stream;


class AdminController {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $nombre = $param["nombre"];
        $clave = $param["clave"];
     
        

        $adminNuevo = new admin();
        $adminNuevo->nombre = $nombre;
        $adminNuevo->clave = $clave;
        
        $adminNuevo->save();

        $payload = json_encode(array("mensaje" => "Administrador creado con éxito"));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        $admin = admin::where('id', $id)->first();
        $payload = json_encode($admin);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $admins = admin::all();
        $payload = json_encode(array("listaAdmin" => $admins));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $id = $args["id"];

        $nombre = $param["nombre"];
        $clave = $param["clave"];
        

        $adminModificado = admin::where('id', $id)->first();
        $adminModificado->nombre = $nombre;
        $adminModificado->clave = $clave;

        $adminModificado->save();

        $payload = json_encode(array("mensaje" => "Admin modificado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function BorrarUno($request, $response, $args){

        $id = $args["id"];

       

        $adminABorrar = admin::where("id", $id)->first();
        
        $adminABorrar->delete();

        $payload = json_encode(array("mensaje"=> "Admin eliminado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    

}



?>