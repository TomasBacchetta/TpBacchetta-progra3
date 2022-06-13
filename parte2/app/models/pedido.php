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


namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pedido extends Model{
   
   
    protected $fillable = [
        'mesa_id',
        'mozo_id',
        'total',
        'tiempo_estimado',
        'estado',
        'foto_mesa',

    ];

    use SoftDeletes;
    
    /*
    public function orden()
    {
        return $this->hasMany(Comment::class);
    }
    */
    
    

    

    

    
}



?>