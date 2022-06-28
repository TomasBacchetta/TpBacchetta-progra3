<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 4
ALTA
VISUALIZACION
BASE DE DATOS

*/
/*
estado:
-con cliente esperando pedido (automatico cuando se carga un pedido para esa mesa)
-con cliente comiendo (la pone el mozo cuando entrega el pedido que esta preparado)
-con cliente pagando (la pone el mozo cuandoesta pagando el cliente. Permite generar factura)
-cerrada (la pone el socio solamente)

*/

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Capsule\Manager as Capsule;

class mesa extends Model{

    public $incrementing = true;
    
    protected $fillable = [
        'estado',
        'puntaje'
    ];
    

   use SoftDeletes;

    public static function existeMesa($id){
        $mesa = mesa::where("id", $id)->first();
        if (isset($mesa)){
            return true;
        } else {
            return false;
        }
        
    }

    public static function existeMesa_PorId($id){
        $mesa = mesa::where("id", "=", $id)->withTrashed()->first();
        if (isset($mesa)){
            return true;
        } else {
            return false;
        }
        
    }
    public static function existeMesa_PorIdSinBorradas($id){
        $mesa = mesa::where("id", "=", $id)->first();
        if (isset($mesa)){
            return true;
        } else {
            return false;
        }
        
    }

    public static function MesaTienePedido($id){
        $pedido = pedido::where("mesa_id", $id)->first();
        if (isset($pedido)){
            return true;
        } else {
            return false;
        }
        
    }

    public static function actualizarPuntajeMesaDeUnPedido($pedido_id){
        $pedido = pedido::where("id", $pedido_id)->first();
        $mesa = mesa::where("id", $pedido->mesa_id)->first();
        $sumatoriaPuntajes = 0;

        $encuestasDeEsaMesa = Capsule::table('encuestas')
        ->join('pedidos', 'pedidos.id', '=', 'encuestas.pedido_id')
        ->select('encuestas.*')
        ->where('pedidos.mesa_id', $mesa->id)->get();

        if (count($encuestasDeEsaMesa) > 0){
            foreach ($encuestasDeEsaMesa as $eEncuesta){
                $sumatoriaPuntajes += $eEncuesta->calificacion_mesa;
            }
            
            $puntaje = $sumatoriaPuntajes/count($encuestasDeEsaMesa);
            $mesa->puntaje = $puntaje;
            $mesa->save();
        }

    }
            

            
        
}



?>