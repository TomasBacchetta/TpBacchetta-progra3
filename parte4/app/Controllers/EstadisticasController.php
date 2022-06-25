<?php


use GuzzleHttp\Psr7\Stream;

    class EstadisticasController{

        public static function MostrarEstadisticaGeneral($request, $response, $args){
            estadisticas::ImprimirEstadisticasGenerales()->Output(date("y-m-d") .'.pdf', 'I');
            return $response->withHeader("Content-Type", "application/pdf");
        }

    }



?>