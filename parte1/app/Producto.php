<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/
class Producto {
    public $id_producto;
    public $descripcion;
    public $precio;
    public $stock;
    public $sector;
    public $tiempo_estimado;
    

    public function crearProducto(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("INSERT INTO productos (descripcion, precio, stock, sector, tiempo_estimado) VALUES (:descripcion, :precio, :stock, :sector, :tiempo_estimado)");
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo_estimado', $this->tiempo_estimado, PDO::PARAM_STR);
        

        $consulta->execute();

        return $objetoAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from productos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function obtenerProducto($id_producto){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from productos WHERE id_producto = :id_producto");
        $consulta->bindValue(':id_producto', $id_producto, PDO::PARAM_INT);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'Producto');
        return $consulta->fetch();
    }

    public function modificarProducto(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("UPDATE productos SET descripcion = :descripcion, stock = :stock, sector = :sector, precio = :precio, tiempo_estimado = :tiempo_estimado WHERE id_producto = :id_producto");
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo_estimado', $this->tiempo_estimado, PDO::PARAM_STR);
        $consulta->bindValue(':id_producto', $this->id_producto, PDO::PARAM_INT);
        $consulta->execute(); 

    }

    
    public function borrarProducto(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("DELETE * from productos WHERE id_producto = :id_producto");
        $consulta->bindValue(':id_producto', $this->id_producto, PDO::PARAM_INT);

        $consulta->execute();
    }

    
    
}



?>