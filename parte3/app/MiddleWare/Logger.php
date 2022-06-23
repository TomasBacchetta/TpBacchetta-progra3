<?php

use GuzzleHttp\Psr7\Response;
use Psr7Middlewares\Middleware\Payload;
use App\Models\orden as orden;

class Logger {

    public static function VerificarAdmin($request, $handler)
    {
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        $response = new Response();
        

        if (AutentificadorJWT::ObtenerPuesto($token) == "admin"){
            $response = $handler->handle($request); //ejecuta la funcion del controller
            return $response;
        } else {
            $payload = json_encode(array("Mensaje" => "Usted no es admin. Acceso denegado"));
            $response->getBody()->write($payload);
            return $response->withStatus(403);
        }
        

        
        
    }

    
    //TRABAJAR CON ESTO
    /*
    $id = self::ObtenerId($token);
        if (self::ObtenerPuesto($token) == "Admin"){
            if (!admin::existeEmpleado_PorIdSinBorrar($id)){
                throw new Exception("Ese admin ya no existe");
            }

            
        } else {
            if (!empleado::existeEmpleado_PorIdSinBorrar($id) ||
                empleado::where("id", $id)->first()->estado == "Inactivo"){
                    throw new Exception("Ese empleado ya no existe o esta inactivo");
            }
            
        }

    */

    public static function VerificarAdminOMozo($request, $handler)
    {
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        $response = new Response();
        

        if (AutentificadorJWT::ObtenerPuesto($token) == "admin" ||
            AutentificadorJWT::ObtenerPuesto($token) == "Mozo"){
            $response = $handler->handle($request); //ejecuta la funcion del controller
            return $response;
        } else {
            $payload = json_encode(array("Mensaje" => "Usted no es admin o mozo. Acceso denegado"));
            $response->getBody()->write($payload);
            
            return $response->withStatus(403);
        }
        

        
        
    }

    public static function VerificarMozo($request, $handler)
    {
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        $response = new Response();
        

        if (AutentificadorJWT::ObtenerPuesto($token) == "Mozo"){
            $response = $handler->handle($request); //ejecuta la funcion del controller
            return $response;
        } else {
            $payload = json_encode(array("Mensaje" => "Usted no es mozo. Acceso denegado"));
            $response->getBody()->write($payload);
            
            return $response->withStatus(403);
        }
        
        
    }

    public static function VerificarNoMozo($request, $handler)
    {
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        $response = new Response();
        

        if (AutentificadorJWT::ObtenerPuesto($token) != "Mozo"){
            $response = $handler->handle($request); //ejecuta la funcion del controller
            return $response;
        } else {
            $payload = json_encode(array("Mensaje" => "Los mozos no pueden acceder a las ordenes. Acceso denegado"));
            $response->getBody()->write($payload);
            
            return $response->withStatus(403);
        }
        

        
        
    }


    public static function VerificarEmpleadoEspecifico($request, $handler){
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $url = $request->getUri()->getPath();
        $id_orden = explode('/', $url)[2];
        $response = new Response();
        $id_empleado = AutentificadorJWT::ObtenerId($token);        

        if (orden::SiOrdenEsDelEmpleado($id_orden, $id_empleado) ||
            (orden::ObtenerEstadoPorId($id_orden) == "Abierta" && orden::SiOrdenEsDelSectorDelEmpleado($id_orden, $id_empleado))){
            $response = $handler->handle($request); //ejecuta la funcion del controller
            return $response;
        } else {
            $payload = json_encode(array("Mensaje" => "Esta orden no es suya, o no es de su sector"));
            $response->getBody()->write($payload);
            return $response->withStatus(403);
        }
    }


  

    
   
    
    
    

    

    
}



?>