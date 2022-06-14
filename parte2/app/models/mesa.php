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

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mesa extends Model{
    
    protected $fillable = [
        'estado'
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
}



?>