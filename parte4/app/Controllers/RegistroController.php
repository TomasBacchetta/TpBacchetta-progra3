<?php

/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 4
ALTA
VISUALIZACION
BASE DE DATOS

*/
use \App\Models\registro as registro;
use \App\Models\empleado as empleado;
use GuzzleHttp\Psr7\Stream;
use Http\Factory\Guzzle\StreamFactory;

class RegistroController{

    

    public function TraerUno($request, $response, $args){
        $id = $args["id"];
        
        $log = registro::where("id", $id);
        $payload = json_encode($log);

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
        
    }

    public function TraerTodos($request, $response, $args){
        $logs = registro::orderBy("id", "desc")->get();
        $payload = json_encode(array("listaLogs" => $logs));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function TraerPorEmpleado($request, $response, $args){
        $params = $request->getQueryParams();
        $nombre = $params["nombre"];

        $logs = registro::where("empleado", $nombre)->get();
        $payload = json_encode(array("listaLogs" => $logs));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function TraerPorFecha($request, $response, $args){
        $params = $request->getQueryParams();
        
        
        $logs = registro::where("created_at", "like", "%".time::InvertirFecha($params["fecha"]) ."%")->get();
        $payload = json_encode(array("listaLogs" => $logs));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function TraerEntreDosFechas($request, $response, $args){
        $params = $request->getQueryParams();
        $desde = time::StrFechaToTimestamp($params["desde"]);
        $hasta = time::StrFechaToTimestamp($params["hasta"]);
        
        $logs = registro::whereBetween("created_at",[$desde, $hasta])->get();
        $payload = json_encode(array("listaLogs" => $logs));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");

    }

    public function CrearCsv($request, $response, $args){

        
        $data = registro::withTrashed()->get();
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
                        ->withHeader('Content-Disposition', 'attachment; filename="registros.csv"')
                        ->withHeader('Expires', '0')
                        ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                        ->withHeader('Pragma', 'public')
                        ->withBody($stream);
        
        
    }


    public function ImportarCsv($request, $response, $args){
        $tmpName = $_FILES['csv']['tmp_name'];
        $csvAsArray = array_map('str_getcsv', file($tmpName));
        
        foreach ($csvAsArray as $eObj){
            $registro = new registro();
            $array = explode(';', $eObj[0]);
            if (!registro::existeRegistro_porId($array[0])){
                registro::where("id", $array[0])->forceDelete();//esto es por si hay un id con softdelete, la prioridad la tiene el csv
                $registro->id = $array[0];
                $registro->empleado = $array[1];
                $registro->puesto = $array[2];
                $registro->descripcion = $array[3];
                $registro->created_at = $array[4];
                $registro->updated_at = $array[5];

                $registro->save();
            } else {
                
                $registro = registro::where("id", $array[0])->withTrashed()->first();
                if (count($array) == 7 && (!isset($registro->deleted_at) || $registro->deleted_at != '') &&
                    ($array[6] == null || $array[6] == '')){
                    $registro->deleted_at = null;
                    
                }

                
            }
            

        }
        

        $payload = json_encode(array("mensaje" => "Csv importado con exito"));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");
    }
}



?>