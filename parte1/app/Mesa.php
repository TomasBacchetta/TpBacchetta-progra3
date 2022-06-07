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
estado:
-con cliente esperando pedido (la pone el mozo)
-con cliente comiendo (la pone el mozo cuando esta preparado/entregado el pedido)
-con cliente pagando (la pone el mozo cuandoesta pagando el cliente. Desencadena la generacion de la factura)
-cerrada (la pone el socio solamente)

*/

class Mesa {
    public $numero;
    public $estado;
    

    public function crearMesa(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("INSERT INTO mesas (estado) VALUES (:estado)");
        $consulta->bindValue(':estado', "Cerrada", PDO::PARAM_STR);
        $consulta->execute();

        return $objetoAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT numero, estado from mesas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }

    public static function obtenerMesa($numero){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT numero, estado from mesas WHERE numero = :numero");
        $consulta->bindValue(':numero', $numero, PDO::PARAM_INT);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'Mesa');

        return $consulta->fetch();
    }

    
    public function borrarMesa(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("DELETE * from mesas WHERE numero = :numero");
        $consulta->bindValue(':numero', $this->numero, PDO::PARAM_INT);

        $consulta->execute();

    }

   

    
}



?>