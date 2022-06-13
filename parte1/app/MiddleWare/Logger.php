<?php

use GuzzleHttp\Psr7\Response;
use Psr7Middlewares\Middleware\Payload;

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

    

    

    
}



?>