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
use GuzzleHttp\Psr7\Stream;


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

    public function CrearCsv($request, $response, $args){

        
        $data = empleado::all();
        $csv = fopen('php://memory', 'w');
        
        foreach ($data as $row) {
	        fputcsv($csv, $row->toArray(), ';');
        }

        $stream = new Stream($csv); // create a stream instance for the response body
        rewind($csv);

        return $response->withHeader('Content-Type', 'application/force-download')
                        ->withHeader('Content-Type', 'application/octet-stream')
                        ->withHeader('Content-Type', 'application/download')
                        ->withHeader('Content-Description', 'File Transfer')
                        ->withHeader('Content-Transfer-Encoding', 'binary')
                        ->withHeader('Content-Disposition', 'attachment; filename="empleados.csv"')
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
            $empleado = new empleado();
            $array = explode(';', $eObj[0]);
            if (!empleado::existeEncuesta_PorId($array[0])){
                empleado::where("id", $array[0])->forceDelete();//esto es por si hay un id con softdelete, la prioridad la tiene el csv
                $empleado->id = $array[0];
                $empleado->nombre = $array[1];
                $empleado->clave = $array[2];
                $empleado->puesto = $array[3];
                $empleado->puntaje = $array[4];
                $empleado->created_at = $array[5];
                $empleado->updated_at = $array[6];
                

                $empleado->save();
            }
            

        }
        

        $payload = json_encode(array("mensaje" => "Csv importado con exito"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
    }


    

    

}



?>