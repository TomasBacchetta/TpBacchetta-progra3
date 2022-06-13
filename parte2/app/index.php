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
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Redis;

require __DIR__ . '/../vendor/autoload.php';

require_once './Middleware/AutentificadorJWT.php';
require_once './Middleware/MiddlewareJWT.php';
require_once './Middleware/Logger.php';
require_once './Middleware/ValidadorParams.php';
require_once './Middleware/FiltrosListas.php';


require_once "./Controllers/LoginController.php";


require_once './models/empleado.php';
require_once "./Controllers/EmpleadoController.php";
require_once "./models/mesa.php";
require_once "./Controllers/MesaController.php";
require_once "./models/producto.php";
require_once "./Controllers/ProductoController.php";
require_once "./models/pedido.php";
require_once "./Controllers/PedidoController.php";  
require_once "./models/orden.php";
require_once "./Controllers/OrdenController.php";
require_once './models/admin.php';
require_once "./Controllers/AdminController.php";


// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

//ORM
$container=$app->getContainer();
$capsule = new Capsule();

$capsule->addConnection([
  'driver' => 'mysql',
  'host' => $_ENV['MYSQL_HOST'],
  'database' => $_ENV['MYSQL_DB'],
  'username' => $_ENV['MYSQL_USER'],
  'password' => $_ENV['MYSQL_PASS'],
  'charset' => 'utf8',
  'collation' => 'utf8_unicode_ci',
  'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

//routes
$app->group("/admins", function (RouteCollectorProxy $group) {
  $group->get('[/]', \AdminController::class . ':TraerTodos');
  $group->get('/{id}', \AdminController::class . ':TraerUno');
  $group->post('[/]', \AdminController::class . ':CargarUno');
  $group->put('/{id}', \AdminController::class . ':ModificarUno');
  $group->delete('/{id}', \AdminController::class . ':BorrarUno');
})->add(\ValidadorParams::class . ':ValidarParamsAdmins')->add(\Logger::class . ':VerificarAdmin')->add(\MiddlewareJWT::class . ':ValidarToken');

$app->group("/empleados", function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadoController::class . ':TraerTodos');
    $group->get('/{id}', \EmpleadoController::class . ':TraerUno');
    $group->post('[/]', \EmpleadoController::class . ':CargarUno');
    $group->put('/{id}', \EmpleadoController::class . ':ModificarUno');
    $group->delete('/{id}', \EmpleadoController::class . ':BorrarUno');
})->add(\ValidadorParams::class . ':ValidarParamsEmpleados')->add(\Logger::class . ':VerificarAdmin')->add(\MiddlewareJWT::class . ':ValidarToken');

$app->group("/mesas", function (RouteCollectorProxy $group) {
  $group->get('[/]', \MesaController::class . ':TraerTodos');
  $group->get('/{id}', \MesaController::class . ':TraerUno');
  $group->post('[/]', \MesaController::class . ':CargarUno');
  $group->put('/{id}', \MesaController::class . ':ModificarUno');
  $group->delete('/{id}', \MesaController::class . ':BorrarUno');
})->add(\ValidadorParams::class . ':ValidarParamsMesas')->add(\Logger::class . ':VerificarAdminOMozo')->add(\MiddleWareJWT::class . ':validarToken');

$app->group("/productos", function (RouteCollectorProxy $group){
  $group->get('[/]', \ProductoController::class . ':TraerTodos')->add(\FiltrosListas::class . ':FiltrarVistaProductos');
  $group->get('/{id}', \ProductoController::class . ':TraerUno');
  $group->post('[/]', \ProductoController::class . ':CargarUno')->add(\Logger::class . ':VerificarAdmin');
  $group->put('/{id}', \ProductoController::class . ':ModificarUno')->add(\Logger::class . ':VerificarAdmin');
  $group->delete('/{id}', \ProductoController::class . ':BorrarUno')->add(\Logger::class . ':VerificarAdmin');

})->add(\ValidadorParams::class . ':ValidarParamsProductos')->add(\MiddleWareJWT::class . ':validarToken');

$app->group("/pedidos", function (RouteCollectorProxy $group){
  $group->get('[/]', \PedidoController::class . ':TraerTodos');
  $group->get('/{id}', \PedidoController::class . ':TraerUno');
  $group->post('[/]', \PedidoController::class . ':CargarUno');
  $group->post('/{id}', \PedidoController::class . ':CambiarEstado');
  $group->put('/{id}', \PedidoController::class . ':ModificarUno');
  $group->delete('/{id}', \PedidoController::class . ':BorrarUno');
})->add(\MiddleWareJWT::class . ':validarToken');

$app->group("/ordenes", function (RouteCollectorProxy $group){
  $group->get('[/]', \OrdenController::class . ':TraerTodos');
  $group->get('/{id}', \OrdenController::class . ':TraerUno');
  $group->post('[/]', \OrdenController::class . ':CargarUno');
  $group->post('/{id}', \OrdenController::class . ':CambiarEstado');
  $group->put('/{id}', \OrdenController::class . ':ModificarUno');
  $group->delete('/{id}', \OrdenController::class . ':BorrarUno');
})->add(\MiddleWareJWT::class . ':validarToken');

$app->group('/login', function (RouteCollectorProxy $group) {
  $group->post('[/]', \LoginController::class . ':verificarUsuario');
});





// JWT rutas TEST
$app->group('/jwt', function (RouteCollectorProxy $group) {
  $group->get('/devolverPayLoad', function (Request $request, Response $response) {
    $header = $request->getHeaderLine('Authorization');
    $token = trim(explode("Bearer", $header)[1]);

    try {
      $payload = json_encode(array('payload' => AutentificadorJWT::ObtenerPayLoad($token)));
    } catch (Exception $e) {
      $payload = json_encode(array('error' => $e->getMessage()));
    }

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  });

  $group->get('/devolverPuesto', function (Request $request, Response $response) {
    $header = $request->getHeaderLine('Authorization');
    $token = trim(explode("Bearer", $header)[1]);

    try {
      $payload = json_encode(array('puesto' => AutentificadorJWT::ObtenerPuesto($token)));
    } catch (Exception $e) {
      $payload = json_encode(array('error' => $e->getMessage()));
    }

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  });

  $group->get('/verificarToken', function (Request $request, Response $response) {
    $header = $request->getHeaderLine('Authorization');
    $token = trim(explode("Bearer", $header)[1]);
    $esValido = false;

    try {
      AutentificadorJWT::verificarToken($token);
      $esValido = true;
    } catch (Exception $e) {
      $payload = json_encode(array('error' => $e->getMessage()));
    }

    if ($esValido) {
      $payload = json_encode(array('valid' => $esValido));
    }

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  });
});





$app->get('[/]', function (Request $request, Response $response) {
    $response->getBody()->write("TP BACCHETTA");
    return $response;
});

  $app->run();

?>