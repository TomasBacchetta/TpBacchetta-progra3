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

class empleado extends Model{


    protected $fillable = [
        'nombre',
        'dni',
        'clave',
        'puesto'
    ];

    use SoftDeletes;

    public static function verificarEmpleado($nombre, $clave){
        $empleado = empleado::where("nombre", "=", $nombre)->where("clave", "=", $clave)->first();

        if (isset($empleado)){
            return true;
        } else {
            return false;
        }
    }

    public static function existeEmpleado($nombre){
        $empleado = empleado::where("nombre", "=", $nombre)->first();
        if (isset($empleado)){
            return true;
        } else {
            return false;
        }
        
    }
    
}



?>