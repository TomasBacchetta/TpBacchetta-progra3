<?php

use Illuminate\Support\Facades\Date;

use \App\Models\mesa as mesa;
use \App\Models\pedido as pedido;
use \App\Models\registro as registro;
use \App\Models\empleado as empleado;
use \App\Models\encuesta as encuesta;
use Illuminate\Database\Capsule\Manager as Capsule;


class estadisticas {

    public static function CrearPDF($texto){
        
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, true);
        $pdf->SetMargins(30, 10, -50, true);
        $pdf->addPage();
        
        $pdf->writeHTML($texto, true, false, true, false, '');

        
        ob_end_clean();

        return $pdf;
    }

    public static function ImprimirEstadisticasGenerales(){
        $empleadoMayor = empleado::where("puntaje", empleado::max("puntaje"))->first();
        $empleadoMenor = empleado::where("puntaje", empleado::min("puntaje"))->first();
        $mesaMasUsada = self::ObtenerMesaMasUsadaEnTreintaDias();
        $mesaMenosUsada = self::ObtenerMesaMenosUsadaEnTreintaDias();
        $mesaMasFacturo = self::ObtenerMesaQueMasFacturoEnTreintaDias();
        $mesaMenosFacturo = self::ObtenerMesaQueMenosFacturoEnTreintaDias();

        $puntuacionRestaurante = 
        $texto = '<img src="./logo/logo.png" alt="test alt attribute" width="60" height="60" border="0" />
                    <h1>Estadisticas historicas</h1> <br>
                    El empleado con mayor puntaje es: ' . $empleadoMayor->nombre . ' con '. $empleadoMayor->puntaje  . ' puntos<br>
                    El empleado con menor puntaje es: ' . $empleadoMenor->nombre  . ' con '. $empleadoMenor->puntaje . ' puntos<br>
                    La puntuacion del restaurante es de:' . self::ObtenerPuntajeDelRestaurante() . '<br>

                    <h1>Estadisticas a 30 dias desde la fecha ' . date("y-m-d") . '</h1> <br>
                    
                    La mesa mas usada fue la N°: ' . $mesaMasUsada[0]  . ', usada ' . $mesaMasUsada[1]  . ' veces <br>
                    La mesa menos usada fue la N°: ' . $mesaMenosUsada[0]  . ', usada ' . $mesaMenosUsada[1]  . ' veces <br>
                    La mesa que mas facturo fue la N°: ' . $mesaMasFacturo[0] . ' ,por un monto de $' . $mesaMasFacturo[1] . '<br>
                    La mesa que menos facturo fue la N°: ' . $mesaMenosFacturo[0] . ' ,por un monto de $' . $mesaMenosFacturo[1] . '<br> <br> 
                    Mesa/s con mayor importe: <br> 
                    ' . self::ObtenerMesasConFacturaDeMayorImporte() . ' <br> <br> 
                    Mesa/s con menor importe: <br> 
                    ' . self::ObtenerMesasConFacturaDeMenorImporte() . '
                    ';

        return self::CrearPDF($texto);
    }

    /*
    MAS COSAS PARA EL PDF:
    La mesa que tuvo el pedido con el mayor importe fue la N°' . NMESA . 'por $' . IMPORTE .'
    Se hicieron'  . NPEDIDOS . 'pedidos
    Se facturaron $'. FACTURACIONATREINTADIAS .'

    */
    /*
    public static function ImprimirMejoresComentarios(){
        $mejoresComentarios = "<dl>";

        foreach ($ordenes as $eOrden){
            $producto = producto::where("id", $eOrden->producto_id)->first();
            $textoOrdenes .= '<dt> x' . $eOrden->cantidad . ' ' . $producto->descripcion . '-------$' . $producto->precio . '</dt>';
            $textoOrdenes .= '<dd>Subtotal: $' . $eOrden->subtotal . '</dd>';
        }

        $textoOrdenes .= "</dl>";
    }
*/
    public static function ObtenerMesasConFacturaDeMayorImporte(){
        $mesas = self::ObtenerFacturasMasCostosasEnTreintaDias();
        $texto = "";
        foreach ($mesas as $key => $value){
            $texto .= "La mesa N° " . $key . ", con una factura de $" . $value . "<br>&nbsp;"; 
        }
        return $texto;
    }

    public static function ObtenerMesasConFacturaDeMenorImporte(){
        $mesas = self::ObtenerFacturasMenosCostosasEnTreintaDias();
        $texto = "";
        foreach ($mesas as $key => $value){
            $texto .= "La mesa N° " . $key . ", con una factura de $" . $value . " <br>&nbsp;"; 
        }
        return $texto;
    }

    public static function ImprimirFacturadoEntreDosFechas($fecha1, $fecha2){
        
    }

    public static function ObtenerPuntajeDelRestaurante(){
        $puntajeRestaurante = "(Aun no calificado)";
        if (encuesta::count() > 0){
            $puntajeRestaurante = encuesta::sum("calificacion_restaurante")/encuesta::count();
        }

        return $puntajeRestaurante;
    }

    public static function ObtenerMesaMasUsadaEnTreintaDias(){
        $fechaActual = Date::now()->subHours(3);
        $fechaMesAtras = Date::now()->subHours(3)->subDays(30);
       

        $idMesaMasUsada = pedido::select('mesa_id')
        ->whereBetween('created_at', [$fechaMesAtras, $fechaActual])
        ->groupBy('mesa_id')
        ->orderByRaw('COUNT(*) DESC')
        ->first()
        ->value('mesa_id');
        
        $cantidadUsos = pedido::where("mesa_id", $idMesaMasUsada)->count();
        
        return array($idMesaMasUsada, $cantidadUsos);
        


    }

    public static function ObtenerMesaMenosUsadaEnTreintaDias(){
        $fechaActual = Date::now()->subHours(3);
        $fechaMesAtras = Date::now()->subHours(3)->subDays(30);
       

        $idMesaMenosUsada = pedido::select('mesa_id')
        ->whereBetween('created_at', [$fechaMesAtras, $fechaActual])
        ->groupBy('mesa_id')
        ->orderByRaw('COUNT(*) ASC')
        ->take(-1)
        ->value('mesa_id');
        
        $cantidadUsos = pedido::where("mesa_id", $idMesaMenosUsada)->count();
        
        return array($idMesaMenosUsada, $cantidadUsos);
        


    }

    public static function ObtenerMesaQueMasFacturoEnTreintaDias(){
         $mesas = self::ObtenerFacturadoPorMesaEnTreintaDias();
         arsort($mesas);
         $array = array(key($mesas), reset($mesas));    
         return $array;
    }

    public static function ObtenerMesaQueMenosFacturoEnTreintaDias(){
        $mesas = self::ObtenerFacturadoPorMesaEnTreintaDias();
        asort($mesas);
        $array = array(key($mesas), reset($mesas));    
        return $array;   
    }

    public static function ObtenerFacturadoPorMesaEnTreintaDias(){
        $fechaActual = Date::now()->subHours(3);
        $fechaMesAtras = Date::now()->subHours(3)->subDays(30);
        $mesas = mesa::all();
        $arrayMesas = array();
        $mayor = 0;
        foreach ($mesas as $eMesa){
            $total = pedido::where("mesa_id", $eMesa->id)
            ->where("estado", "Pagado")
            ->whereBetween('created_at', [$fechaMesAtras, $fechaActual])->sum("total");
            $arrayMesas[$eMesa->id] = $total;
        }

        return $arrayMesas;
    }

    public static function ObtenerFacturasMasCostosasEnTreintaDias(){
        $fechaActual = Date::now()->subHours(3);
        $fechaMesAtras = Date::now()->subHours(3)->subDays(30);
        $pedidos = pedido::whereBetween('created_at', [$fechaMesAtras, $fechaActual])->get();
        $mayor = pedido::whereBetween('created_at', [$fechaMesAtras, $fechaActual])->max("total");
        $mesas = array();


        foreach ($pedidos as $ePedido){
            if ($ePedido->total == $mayor){
                $mesas[$ePedido->mesa_id] = $ePedido->total;
            }
        }


        return $mesas;
    }

    public static function ObtenerFacturasMenosCostosasEnTreintaDias(){
        $fechaActual = Date::now()->subHours(3);
        $fechaMesAtras = Date::now()->subHours(3)->subDays(30);
        $pedidos = pedido::whereBetween('created_at', [$fechaMesAtras, $fechaActual])->get();
        $minimo = pedido::whereBetween('created_at', [$fechaMesAtras, $fechaActual])->min("total");
        $mesas = array();

        foreach ($pedidos as $ePedido){
            if ($ePedido->total == $minimo){
                $mesas[$ePedido->mesa_id] = $ePedido->total;
            } 
        }

        return $mesas;
    }

    
    
}



?>