<?php

use \App\Models\empleado as empleado;
use \App\Models\admin as admin;
//use \App\Middleware\AutentificadorJWT as AutentificadorJWT;


class LoginController {
    public function VerificarUsuario($request, $response, $args){
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $clave = $parametros['clave'];


        if (empleado::verificarEmpleado($nombre, $clave)){
            $tokenNuevo = AutentificadorJWT::CrearToken(
                empleado::where("nombre", $nombre)->value("puesto"), 
                empleado::where("nombre", $nombre)->value("id")
            );
            $response->getBody()->write(json_encode(array("token"=>$tokenNuevo)));

            return $response;
        }
        if (admin::verificarAdmin($nombre, $clave)){
            $tokenNuevo = AutentificadorJWT::CrearToken("admin", 999);
            $response->getBody()->write(json_encode(array("token"=>$tokenNuevo)));

            return $response;
        }
        
        $response->getBody()->write("Datos erróneos");
        return $response->withStatus(403);
        
    }

    public function VerificarCliente($request, $response, $args){
        $parametros = $request->getParsedBody();

        $mesa_id = $parametros['mesa_id'];
        $pedido_id = $parametros['pedido_id'];

        /*
        if (empleado::verificarEmpleado($nombre, $clave)){
            $tokenNuevo = AutentificadorJWT::CrearToken(
                empleado::where("nombre", $nombre)->value("puesto"), 
                empleado::where("nombre", $nombre)->value("id")
            );
            $response->getBody()->write(json_encode(array("token"=>$tokenNuevo)));

            return $response;
        }
        if (admin::verificarAdmin($nombre, $clave)){
            $tokenNuevo = AutentificadorJWT::CrearToken("admin", 999);
            $response->getBody()->write(json_encode(array("token"=>$tokenNuevo)));

            return $response;
        }
        
        $response->getBody()->write("Datos erróneos");
        return $response->withStatus(403);
        */
        $tokenNuevo = AutentificadorJWT_Clientes::CrearToken($mesa_id, $pedido_id);
        $response->getBody()->write(json_encode(array("token"=>$tokenNuevo)));

        return $response;

        
        
    }
}

?>