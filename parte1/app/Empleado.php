<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
class Empleado{
    public $id;
    public $nombre;
    public $dni;
    public $clave;
    public $puesto;
    public $puntaje;
    public $fecha_de_alta;
    public $fecha_de_baja;

    public function crearEmpleado(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("INSERT INTO empleados (nombre, dni, clave, puesto, fecha_de_alta) VALUES (:nombre, :dni, :clave, :puesto, :fecha_de_alta)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':dni', $this->dni, PDO::PARAM_INT);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_INT);
        $consulta->bindValue(':puesto', $this->puesto, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_de_alta', $this->fecha_de_alta, PDO::PARAM_STR);
        $consulta->execute();

        return $objetoAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT id, nombre, dni, clave, puesto, puntaje, fecha_de_alta, fecha_de_baja from empleados");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Empleado');
    }

    public static function obtenerEmpleado($id){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT id, nombre, dni, clave, puesto, puntaje, fecha_de_alta, fecha_de_baja from empleados WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'Empleado');

        return $consulta->fetch();
    }

    public function modificarEmpleado(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("UPDATE empleados SET nombre = :nombre, clave = :clave, puesto = :puesto WHERE id = :id");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':dni', $this->dni, PDO::PARAM_INT);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_INT);
        $consulta->bindValue(':puesto', $this->puesto, PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute(); 

    }
    
    public function borrarEmpleado(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("UPDATE empleados SET fecha_de_baja = :fecha_de_baja WHERE nombre = :nombre, dni = :dni");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':dni', $this->dni, PDO::PARAM_INT);

        $consulta->execute();

    }

    public static function verificarEmpleado($nombre, $clave){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT nombre, clave FROM empleados WHERE nombre = :nombre && clave = :clave");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_INT);
        
        return $consulta->execute();

        
    }
}



?>