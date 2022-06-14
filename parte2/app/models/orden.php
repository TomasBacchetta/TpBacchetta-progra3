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

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Capsule\Manager as Capsule;


class orden extends Model{
    
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'empleado_id',
        'cantidad',
        'subtotal',
        'tiempo_inicio',
        'tiempo_estimado',
        'estado'

    ];

    

    use SoftDeletes;
    
    /*
    public function pedido()
    {
        return $this->hasOne(pedido::class);
    }
    */
    
    public static function ObtenerOrdenesEnPreparacionPorPedido($pedido_id){
        $ordenes = orden::where("pedido_id", $pedido_id)->get();

        if (isset($ordenes)){
            return $ordenes;
        } else {
            return false;
        }
    }

    public static function ObtenerOrdenesAbiertasPorPedido($pedido_id){
        $orden = orden::where("pedido_id", $pedido_id)->where("estado", "Abierta")->first();
        if (isset($orden)){
            return $orden;
        } else {
            return false;
        }
    }

    public static function ObtenerSectorPorId($id){
        return orden::where("id", $id)->value("sector");
    }

    public static function ObtenerEstadoPorId($id){
        return orden::where("id", $id)->value("estado");
    }

    public static function SiOrdenEsDelEmpleado($id, $empleado_id){
        $orden = orden::where("id", $id)->where("empleado_id", $empleado_id)->first();
        if (isset($orden)){
            return $orden;
        } else {
            return false;
        }
    }

    public static function ObtenerOrdenesPorSector($sector){
        $ordenes = Capsule::table('ordens')
        ->join('productos', 'productos.id', '=', 'ordens.producto_id')
        ->select('ordens.*')
        ->where('productos.sector', $sector)->orderBy("ordens.pedido_id", "desc")
        ->get();

        if (isset($ordenes)){
            return $ordenes;
        } else {
            return false;
        }
    }

    


    

    

    
}



?>