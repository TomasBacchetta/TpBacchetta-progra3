<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
/*
estados:
-Iniciada (automático al crear el pedido)
-En preparacion (cambiado por el empleado correspondiente)
-Preparada

*/


class Orden {
    public $num_orden;
    public $num_pedido;
    public $num_producto;
    public $descripcion;
    public $cantidad;
    public $subtotal;
    public $tiempo_inicio;
    public $tiempo_estimado;
    public $estado;
    public $calificacion_empleado;
    

    public function crearOrden(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta(
            "INSERT INTO ordenes (
                num_pedido, 
                num_producto, 
                descripcion, 
                cantidad, 
                subtotal, 
                tiempo_estimado,
                estado) 
                VALUES (:num_pedido, :num_producto, :descripcion, :cantidad, :subtotal, :tiempo_estimado, :estado)");
        $consulta->bindValue(':num_pedido', $this->num_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':num_producto', $this->num_producto, PDO::PARAM_INT);
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':subtotal', $this->subtotal, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo_estimado', $this->tiempo_estimado, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
      
        $consulta->execute();

        return $objetoAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerOrdenes(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from ordenes");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Orden');
    }

    public static function obtenerOrden($num_orden){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from ordenes WHERE num_orden = :num_orden");
        $consulta->bindValue(':num_orden', $num_orden, PDO::PARAM_INT);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'Orden');
        
        return $consulta->fetch();
    }

    public static function obtenerOrdenesPorNumPedido($num_pedido){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from ordenes WHERE num_pedido = :num_pedido");
        $consulta->bindValue(':num_pedido', $num_pedido, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Orden');
    }


    public function modificarOrden(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("UPDATE ordenes SET 
            num_pedido = :num_pedido, 
            num_producto = :num_producto, 
            descripcion = :descripcion, 
            cantidad = :cantidad, 
            subtotal = :subtotal,
            tiempo_inicio = :tiempo_inicio,
            tiempo_estimado = :tiempo_estimado,
            estado = :estado,
            calificacion_empleado = :calificacion_empleado
            WHERE num_orden = :num_orden");
        $consulta->bindValue(':num_pedido', $this->num_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':num_producto', $this->num_producto, PDO::PARAM_INT);
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':subtotal', $this->subtotal, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo_estimado', $this->tiempo_estimado, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo_inicio', $this->tiempo_inicio, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':calificacion_empleado', $this->calificacion_empleado, PDO::PARAM_INT);
        $consulta->bindValue(':num_orden', $this->num_orden, PDO::PARAM_INT);
        $consulta->execute(); 

    }

    
    public function borrarOrden(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("DELETE * from ordenes WHERE num_orden = :num_orden");
        $consulta->bindValue(':num_orden', $this->num_orden, PDO::PARAM_INT);

        $consulta->execute();
    }

    public static function obtenerMontoTotalDeOrdenesPorNumPedido($numPedido){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT SUM(subtotal) from ordenes WHERE num_pedido = :num_pedido");
        $consulta->bindValue(':num_pedido', $numPedido, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchColumn();
    }
    
    public static function obtenerTiempoEstimadoMayorPorNumPedido($numPedido){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT MAX(tiempo_estimado) from ordenes WHERE num_pedido = :num_pedido");
        $consulta->bindValue(':num_pedido', $numPedido, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchColumn();
    }

 



    

    

    
}



?>