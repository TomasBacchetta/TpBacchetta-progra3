<?php

use GuzzleHttp\Psr7\Response;
use Psr7Middlewares\Middleware\Payload;
use \App\Models\admin as admin;
use App\Models\empleado as empleado;
use App\Models\producto;

class ValidadorParams {

    public static function ValidarParamsAdmins($request, $handler){
        $method = $request->getMethod();
        
        $response = new Response();

        if ($method == "POST" || $method == "PUT"){
            $dato = $request->getParsedBody();
            $error = false;
            $mensaje = "";
            
            
            if (!isset($dato)){
                $payload = json_encode(array("Mensaje" => "Faltan todos los parametros"));
                $response->getBody()->write($payload);
                return $response->withStatus(403);
                
            } else {
                if (!array_key_exists("nombre", $dato)){
                    $mensaje .= "Falta el parametro de nombre. ";
                    $error = true;   
                } else {
                    if ($method == "POST"){
                        if (admin::existeAdmin($dato["nombre"])){
                            $mensaje .= "Ya existe ese admin. ";
                            $error = true;
                        }
                    }
                    
                    if ($dato["nombre"] == ""){
                        $mensaje .= "Nombre invalido. ";
                        $error = true;
                    }
                }
                if (!array_key_exists("clave", $dato)){
                    $mensaje .= "Falta el parametro de clave";
                    $error = true;  
                } else {
                    if ($dato["clave"] == "" || is_nan($dato["clave"])){
                        $mensaje .= "Clave invalida. ";
                        $error = true;
                    } 
                }
                
               
                
                if ($error){
                    
                    $payload = json_encode(array("Mensaje" => $mensaje));
                    $response->getBody()->write($payload);
                    return $response->withStatus(403); 
                }
                
                    
            }

            
        }
        

        $response = $handler->handle($request);
        return $response;
        
          
    }


    public static function ValidarParamsEmpleados($request, $handler){
        $method = $request->getMethod();
        
        $response = new Response();

        if ($method == "POST" || $method == "PUT"){
            $dato = $request->getParsedBody();
            $error = false;
            $mensaje = "";
            
            
            if (!isset($dato)){
                $payload = json_encode(array("Mensaje" => "Faltan todos los parametros"));
                $response->getBody()->write($payload);
                return $response->withStatus(403);
                
            } else {
                if (!array_key_exists("nombre", $dato)){
                    $mensaje .= "Falta el parametro de nombre. ";
                    $error = true;   
                } else {//si existe el parametro
                    if ($method == "POST"){
                        if (empleado::existeEmpleado($dato["nombre"])){
                            $mensaje .= "Ya existe ese empleado. ";
                            $error = true;
                        }
                    }
                    if ($dato["nombre"] == ""){
                        $mensaje .= "Nombre invalido. ";
                        $error = true;
                    }
                }
                if (!array_key_exists("clave", $dato)){
                    $mensaje .= "Falta el parametro de clave";
                    $error = true;  
                } else {//si existe el parametro
                    if ($dato["clave"] == "" || is_nan($dato["clave"])){
                        $mensaje .= "Clave invalida. ";
                        $error = true;
                    } 
                }
                if (!array_key_exists("puesto", $dato)){
                    $mensaje .= "Falta el parametro de puesto";
                    $error = true;  
                } else {//si existe el parametro
                    if ($dato["puesto"] == "" || (
                        $dato["puesto"] != "Mozo" &&
                        $dato["puesto"] != "Cocinero" &&
                        $dato["puesto"] != "Bartender" &&
                        $dato["puesto"] != "Cervecero"

                    )){
                        $mensaje .= "Puesto invalido. ";
                        $error = true;
                    } 
                }
                
               
                
                if ($error){
                    
                    $payload = json_encode(array("Mensaje" => $mensaje));
                    $response->getBody()->write($payload);
                    return $response->withStatus(403); 
                }
                
                    
            }

            
        }
        

        $response = $handler->handle($request);
        return $response;
        
          
    }

    public static function ValidarParamsMesas($request, $handler){
        $method = $request->getMethod();
        
        $response = new Response();

        if ($method == "PUT"){
            $dato = $request->getParsedBody();
            $error = false;
            $mensaje = "";
            
            
            if (!isset($dato)){
                $payload = json_encode(array("Mensaje" => "Faltan todos los parametros"));
                $response->getBody()->write($payload);
                return $response->withStatus(403);
                
            } else {
                if (!array_key_exists("estado", $dato)){
                    $mensaje .= "Falta el parametro de estado. ";
                    $error = true;   
                } else {//si existe el parametro
                    if ($dato["estado"] == "" || (
                        $dato["estado"] != "Con cliente esperando pedido" &&
                        $dato["estado"] != "Con cliente comiendo" &&
                        $dato["estado"] != "Con cliente pagando" &&
                        $dato["estado"] != "Cerrada"
                        )){
                        $mensaje .= "Estado invalido. ";
                        $error = true;
                    } else {
                        $header = $request->getHeaderLine('Authorization');
                        $token = trim(explode("Bearer", $header)[1]);
                        if ($dato["estado"] == "Cerrada" && AutentificadorJWT::ObtenerPuesto($token) != "admin"){
                            $payload = json_encode(array("Mensaje" => "Solo los admins pueden cerrar la mesa"));
                                    $response->getBody()->write($payload);
                                    return $response->withStatus(403);
                        }
                    }
                }
                
                
                if ($error){
                    
                    $payload = json_encode(array("Mensaje" => $mensaje));
                    $response->getBody()->write($payload);
                    return $response->withStatus(403); 
                }
                
                    
            }

            
        }
        

        $response = $handler->handle($request);
        return $response;
        
          
    }

    public static function ValidarParamsProductos($request, $handler){
        $method = $request->getMethod();
        
        $response = new Response();

        if ($method == "POST" || $method == "PUT"){
            $dato = $request->getParsedBody();
            $error = false;
            $mensaje = "";
            
            
            if (!isset($dato)){
                $payload = json_encode(array("Mensaje" => "Faltan todos los parametros"));
                $response->getBody()->write($payload);
                return $response->withStatus(403);
                
            } else {
                if (!array_key_exists("descripcion", $dato)){
                    $mensaje .= "Falta el parametro de la descripcion. ";
                    $error = true;   
                } else {//si existe el parametro
                    if ($method == "POST"){//esto es porque en put es solo modificacion
                        if (producto::existeProducto($dato["descripcion"])){
                            $mensaje .= "Ya existe ese producto. ";
                            $error = true;
                        }
                    }
                    if ($dato["descripcion"] == ""){
                        $mensaje .= "Descripcion invalida. ";
                        $error = true;
                    }
                }
                if (!array_key_exists("precio", $dato)){
                    $mensaje .= "Falta el parametro de precio";
                    $error = true;  
                } else {//si existe el parametro
                    if ($dato["precio"] == "" || is_nan($dato["precio"])){
                        $mensaje .= "Precio invalido. ";
                        $error = true;
                    } 
                }
                if (!array_key_exists("stock", $dato)){
                    $mensaje .= "Falta el parametro de stock. ";
                    $error = true;  
                } else {//si existe el parametro
                    if ($dato["stock"] == "" || 
                        $dato["stock"] < 0){
                        $mensaje .= "Stock invalido. ";
                        $error = true;
                    } 
                }
                if (!array_key_exists("sector", $dato)){
                    $mensaje .= "Falta el parametro de sector. ";
                    $error = true;  
                } else {//si existe el parametro
                    if ($dato["sector"] == "" || (
                        $dato["sector"] != "Cocina" &&
                        $dato["sector"] != "Candy_Bar" &&
                        $dato["sector"] != "Barra_Choperas" &&
                        $dato["sector"] != "Barra_Tragos"

                    )){
                        $mensaje .= "Sector invalido. ";
                        $error = true;
                    } 
                }
                if (!array_key_exists("tiempo_estimado", $dato)){
                    $mensaje .= "Falta el parametro de tiempo estimado. ";
                    $error = true;  
                }
                
               
                
                if ($error){
                    
                    $payload = json_encode(array("Mensaje" => $mensaje));
                    $response->getBody()->write($payload);
                    return $response->withStatus(403); 
                }
                
                    
            }

            
        }
        

        $response = $handler->handle($request);
        return $response;
        
          
    }

    

    

    
}



?>