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
            $tokenNuevo = AutentificadorJWT::CrearToken(empleado::where("nombre", $nombre)->value("puesto"));
            $response->getBody()->write(json_encode(array("token"=>$tokenNuevo)));

            return $response;
        }
        if (admin::verificarAdmin($nombre, $clave)){
            $tokenNuevo = AutentificadorJWT::CrearToken("admin");
            $response->getBody()->write(json_encode(array("token"=>$tokenNuevo)));

            return $response;
        }
        
        $response->getBody()->write("Datos erróneos");
        return $response->withStatus(403);
        
    }
}

?>