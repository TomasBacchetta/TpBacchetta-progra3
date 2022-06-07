<?php

/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/

error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once "AccesoDatos.php";

require_once "Empleado.php";
require_once "EmpleadoController.php";
require_once "Mesa.php";
require_once "MesaController.php";
require_once "Producto.php";
require_once "ProductoController.php";
require_once "Pedido.php";
require_once "PedidoController.php";  
require_once "Orden.php";
require_once "OrdenController.php";  




// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

$app->group("/empleados", function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadoController::class . ':TraerTodos');
    $group->get('/{id}', \EmpleadoController::class . ':TraerUno');
    $group->post('[/]', \EmpleadoController::class . ':CargarUno');
});

$app->group("/mesas", function (RouteCollectorProxy $group) {
  $group->get('[/]', \MesaController::class . ':TraerTodos');
  $group->get('/{numero}', \MesaController::class . ':TraerUno');
  $group->post('[/]', \MesaController::class . ':CargarUno');
});

$app->group("/productos", function (RouteCollectorProxy $group){
  $group->get('[/]', \ProductoController::class . ':TraerTodos');
  $group->get('/{id_producto}', \ProductoController::class . ':TraerUno');
  $group->post('[/]', \ProductoController::class . ':CargarUno');
});

$app->group("/pedidos", function (RouteCollectorProxy $group){
  $group->get('[/]', \PedidoController::class . ':TraerTodos');
  $group->get('/{num_pedido}', \PedidoController::class . ':TraerUno');
  $group->post('[/]', \PedidoController::class . ':CargarUno');
  $group->post('/{num_pedido}', \PedidoController::class . ':CambiarEstado');
});

$app->group("/ordenes", function (RouteCollectorProxy $group){
  $group->get('[/]', \OrdenController::class . ':TraerTodos');
  $group->get('/{num_orden}', \OrdenController::class . ':TraerUno');
  $group->post('[/]', \OrdenController::class . ':CargarUno');
  $group->post('/{num_orden}', \OrdenController::class . ':CambiarEstado');
});

$app->get('[/]', function (Request $request, Response $response) {
    $response->getBody()->write("TP BACCHETTA");
    return $response;
  });

  $app->run();

?>