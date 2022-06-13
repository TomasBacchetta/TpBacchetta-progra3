<?php

use GuzzleHttp\Psr7\Response;
use Psr7Middlewares\Middleware\Payload;
use \App\Models\admin as admin;
use App\Models\empleado as empleado;
use App\Models\producto;

class FiltrosListas {

    public static function FiltrarVistaProductos($request, $handler){
        $method = $request->getMethod();
        
        $response = new Response();

        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $puesto = AutentificadorJWT::ObtenerPuesto($token);
        switch($puesto){
            case "admin":
            case "Mozo":
                $response = $handler->handle($request);
                return $response->withHeader("Content-Type", "application/json");
                break;
            case "Cocinero":
                $productos1 =producto::ObtenerProductosPorSector("Candy_Bar");
                $productos2 =producto::ObtenerProductosPorSector("Cocina");
                $productos = $productos1->concat($productos2);
                break;
            case "Cervecero":
                $productos = producto::ObtenerProductosPorSector("Barra_Choperas");
                break;
            case "Bartender":
                $productos = producto::ObtenerProductosPorSector("Barra_Tragos");
                break;

        }


        $payload = json_encode(array("listaProductos" => $productos));

        $response->getBody()->write($payload);

        return $response->withHeader("Content-Type", "application/json");


        
    }

        



    

    

    

    
}



?>