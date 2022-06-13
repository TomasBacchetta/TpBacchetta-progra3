<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
use \App\Models\empleado as empleado;



class EmpleadoController {


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $nombre = $param["nombre"];
        $clave = $param["clave"];
        $puesto = $param["puesto"];
        

        $empleadoNuevo = new empleado();
        $empleadoNuevo->nombre = $nombre;
        $empleadoNuevo->clave = $clave;
        $empleadoNuevo->puesto = $puesto;
        
        $empleadoNuevo->save();

        $payload = json_encode(array("mensaje" => $puesto . " creado con éxito"));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        $empleado = empleado::where('id', $id)->first();
        $payload = json_encode($empleado);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $empleados = empleado::all();
        $payload = json_encode(array("listaEmpleado" => $empleados));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function ModificarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $id = $param["id"];
        $nombre = $param["nombre"];
        $clave = $param["clave"];
        $puesto = $param["puesto"];
        $dni = $param["dni"];

        $empleadoModificado = empleado::where('id', $id)->first();
        $empleadoModificado->nombre = $nombre;
        $empleadoModificado->clave = $clave;
        $empleadoModificado->puesto = $puesto;
        $empleadoModificado->dni = $dni;

        $empleadoModificado->update();

        $payload = json_encode(array("mensaje" => "Usuario modificado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function BorrarUno($request, $response, $args){

        $id = $args["id"];


        $empleadoABorrar = empleado::where("id", $id);
        
        $empleadoABorrar->delete();

        $payload = json_encode(array("mensaje"=> "Usuario eliminado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    

    

}



?>