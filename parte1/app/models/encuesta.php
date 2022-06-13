<?php
/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS


*/

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class encuesta extends Model{
  
    protected $fillable = [
        'pedido_id',
        'calificacion_mesa',
        'calificacion_restaurante',
        'calificacion_mozo',
        'calificacion_cocinero',
        'calificacion_cervecero',
        'calificacion_bartender',
        'comentario'
    ];

    use SoftDeletes;
    
}



?>