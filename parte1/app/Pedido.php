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
-Abierto (automático al crear el pedido)
-Con orden (automático al incluir al menos una orden)
-Preparado (automático cuando la ultima orden a preparar se marco como preparada)
-Entregado (lo pone el mozo cuando entrega el pedido a la mesa)
-Pagado (hace falta? automático cuando se cierra la mesa)
*/
class Pedido {
    public $num_pedido;
    public $num_mesa;
    public $num_mozo;
    public $total;
    public $tiempo_estimado;
    public $fecha_pedido;
    public $estado;
    public $calificacion_mozo;
    public $calificacion_mesa;
    public $calificacion_restaurante;
    public $comentario;
    public $foto_mesa;
    

    public function crearPedido(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta(
            "INSERT INTO pedidos (
                num_mesa, 
                num_mozo, 
                fecha_pedido,
                estado) 
                VALUES (:num_mesa, :num_mozo, :fecha_pedido, :estado)");
        $consulta->bindValue(':num_mesa', $this->num_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':num_mozo', $this->num_mozo, PDO::PARAM_INT);
        $consulta->bindValue(':fecha_pedido', $this->fecha_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
      

        $consulta->execute();

        return $objetoAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerPedidos(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedido($num_pedido){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("SELECT * from pedidos WHERE num_pedido = :num_pedido");
        $consulta->bindValue(':num_pedido', $num_pedido, PDO::PARAM_INT);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'Pedido');

        return $consulta->fetch();
    }


    public function modificarPedido(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("UPDATE pedidos SET 
            num_mesa = :num_mesa, 
            num_mozo = :num_mozo, 
            total = :total, 
            tiempo_estimado = :tiempo_estimado,
            fecha_pedido = :fecha_pedido,
            estado = :estado,
            calificacion_mozo = :calificacion_mozo,
            calificacion_mesa = :calificacion_mesa,
            calificacion_restaurante = :calificacion_restaurante,
            comentario = :comentario,
            foto_mesa = :foto_mesa
            WHERE num_pedido = :num_pedido");
        $consulta->bindValue(':num_pedido', $this->num_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':num_mesa', $this->num_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':num_mozo', $this->num_mozo, PDO::PARAM_INT);
        $consulta->bindValue(':total', $this->total, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo_estimado', $this->tiempo_estimado, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_pedido', $this->fecha_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':calificacion_mozo', $this->calificacion_mozo, PDO::PARAM_INT);
        $consulta->bindValue(':calificacion_mesa', $this->calificacion_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':calificacion_restaurante', $this->calificacion_restaurante, PDO::PARAM_INT);
        $consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
        $consulta->bindValue(':foto_mesa', $this->foto_mesa, PDO::PARAM_STR);
        
        $consulta->execute(); 

    }

    
    public function borrarPedido(){
        $objetoAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDatos->prepararConsulta("DELETE * from pedidos WHERE num_pedido = :num_pedido");
        $consulta->bindValue(':num_pedido', $this->num_pedido, PDO::PARAM_INT);

        $consulta->execute();
    }

    

    

    

    

    
}



?>