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

class admin extends Model{
  
    protected $fillable = [
        'nombre',
        'clave'
    ];

    use SoftDeletes;

    public static function verificarAdmin($nombre, $clave){
        $admin = admin::where("nombre", "=", $nombre)->where("clave", "=", $clave)->first();

        if (isset($admin)){
            return true;
        } else {
            return false;
        }
    }

    public static function existeAdmin($nombre){
        $admin = admin::where("nombre", "=", $nombre)->first();
        if (isset($admin)){
            return true;
        } else {
            return false;
        }
        
    }
    
}



?>