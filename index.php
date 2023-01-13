<?php

date_default_timezone_set("America/Bogota");

require_once(__DIR__ . "/vendor/autoload.php");

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

header("Access-Control-Allow-Origin: " . $_ENV['ALLOWED_URL']);

// Router
use Api\Http\Router;
use Symfony\Component\HttpFoundation\Request;

// Importar controladores.
use Api\Controllers\Prueba;

//crear un objeto request a partir de las variables globales del servidor
$request = Request::createFromGlobals();

//Rutas
Router::init();

Router::group(['prefix' => '/api/v2'], function($route) {
	$route->filter('CleanInputMiddleware', new \Api\Http\Middlewares\CleanInputMiddleware(Request::createFromGlobals()));

	Router::group(['prefix' => '/test'], function() {
		//Define una ruta para el método GET
        Router::get('/users', function(){
            echo "Lista de usuarios.";
        });

        //Define una ruta para el método GET con un parámetro
        Router::get('/users/{id}', function($id){
            echo "Detalles del usuario con ID: " . $id;
        });

        //Define una ruta para el método POST
        Router::post('/prueba', function() {
        	$p = new Prueba();
        	print_r($p->testRequest());
        });

        //Define una ruta para el método PUT
        Router::put('/users/{id}', function($id){
            echo "Actualizando el usuario con ID: " . $id;
        });

        //Define una ruta para el método DELETE
        Router::delete('/users/{id}', function($id){
            echo "Eliminando el usuario con ID: " . $id;
        });
	});
});

//ejecutar el despachador y obtener la respuesta
Router::dispatch($request);