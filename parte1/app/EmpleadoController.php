<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
require_once "Empleado.php";



class EmpleadoController extends Empleado{


    public function CargarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $nombre = $param["nombre"];
        $dni = $param["dni"];
        $clave = $param["clave"];
        $puesto = $param["puesto"];
        

        $empleadoNuevo = new Empleado();
        $empleadoNuevo->nombre = $nombre;
        $empleadoNuevo->dni = $dni;
        $empleadoNuevo->clave = $clave;
        $empleadoNuevo->puesto = $puesto;
        $empleadoNuevo->fecha_de_alta = date("y-m-d");
        $empleadoNuevo->crearEmpleado();

        $payload = json_encode(array("mensaje" => $puesto . " creado con éxito"));
        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        $empleado = Empleado::obtenerEmpleado($id);
        $payload = json_encode($empleado);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $empleados = Empleado::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $empleados));

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

        $empleadoModificado = new Empleado();
        $empleadoModificado->id = $id;
        $empleadoModificado->nombre = $nombre;
        $empleadoModificado->clave = $clave;
        $empleadoModificado->puesto = $puesto;
        $empleadoModificado->dni = $dni;

        $empleadoModificado->modificarEmpleado();

        $payload = json_encode(array("mensaje" => "Usuario modificado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

        
    }

    public function BorrarUno($request, $response, $args){
        $param = $request->getParsedBody();

        $nombre = $param["nombre"];
        $dni = $param["dni"];

        $empleadoABorrar = new Empleado();
        $empleadoABorrar->nombre = $nombre;
        $empleadoABorrar->dni = $dni;

        $empleadoABorrar->borrarEmpleado();

        $payload = json_encode(array("mensaje"=> "Usuario eliminado exitosamente"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    

}



?>