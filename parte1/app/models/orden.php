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
 



    

    

    
}



?>