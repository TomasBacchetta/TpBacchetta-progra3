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
use Illuminate\Database\Capsule\Manager as Capsule;

class empleado extends Model{

    public $incrementing = true;
    
    protected $fillable = [
        'nombre',
        'clave',
        'puesto',
        'puntaje',
        'estado'
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

    public static function existeMozo($id){
        $empleado = empleado::where("id", $id)->where("puesto", "Mozo")->first();
        if (isset($empleado)){
            return true;
        } else {
            return false;
        }
        
    }

    public static function existeEmpleado_PorId($id){
        $empleado = empleado::where("id", "=", $id)->withTrashed()->first();
        if (isset($empleado)){
            return true;
        } else {
            return false;
        }
        
    }

    public static function ObtenerEmpleadosDeUnPedido($pedido_id){
        $empleados = Capsule::table('empleados')
        ->join('ordens', 'ordens.empleado_id', '=', 'empleados.id')
        ->join('pedidos', 'pedidos.id', '=', 'ordens.pedido_id')
        ->select('empleados.*')
        ->where('pedidos.id', $pedido_id)->get();
        return $empleados;

    }

    public static function actualizarPuntajeEmpleadosDeUnPedido($pedido_id){

        $empleados = empleado::ObtenerEmpleadosDeUnPedido($pedido_id);

        foreach ($empleados as $eEmpleado){
            $sumatoriaPuntajes = 0;
            switch ($eEmpleado->puesto){
                case "Cocinero":
                    $tipoDePuntaje = "calificacion_cocinero";
                    break;
                case "Bartender":
                    $tipoDePuntaje = "calificacion_bartender";
                    break;
                case "Cervecero":
                    $tipoDePuntaje = "calificacion_cervecero";
                    break;
            }
            $encuestas = Capsule::table('encuestas')
            ->join('pedidos', 'pedidos.id', '=', 'encuestas.pedido_id')
            ->join('ordens', 'ordens.pedido_id', '=', 'pedidos.id')
            ->join('empleados', 'empleados.id', '=', 'ordens.empleado_id')
            ->select('encuestas.*')
            ->where('empleados.id', $eEmpleado->id)->get();

            if (count($encuestas) > 0){
                foreach ($encuestas as $eEncuesta){
                    $sumatoriaPuntajes += $eEncuesta->$tipoDePuntaje;
                }
                
                $empleadoAModificar = empleado::where("id", $eEmpleado->id)->first();
                $puntaje = $sumatoriaPuntajes/count($encuestas);
                $empleadoAModificar->puntaje = $puntaje;
                $empleadoAModificar->save();
            }
            
            //$eEmpleado->save();
        }
        

        
    }
    
}



?>