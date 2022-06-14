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

    public static function VerificarEmpleadoEspecifico($request, $handler){
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $url = $request->getUri()->getPath();
        $id_orden = explode('/', $url)[2];
        $response = new Response();
        

        if (orden::SiOrdenEsDelEmpleado($id_orden, AutentificadorJWT::ObtenerId($token)) ||
            orden::ObtenerEstadoPorId($id_orden) == "Abierta"){
            $response = $handler->handle($request); //ejecuta la funcion del controller
            return $response;
        } else {
            $payload = json_encode(array("Mensaje" => "Esta orden no es suya"));
            $response->getBody()->write($payload);
            return $response->withStatus(403);
        }
    }

    
   
    
    
    

    

    
}



?>