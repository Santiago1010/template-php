<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Allow: GET, POST, PUT, DELETE");
//header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set("America/Bogota");

require_once(__DIR__ . "/vendor/autoload.php");

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Api\Http\Router;

// Importar controladores.
use Api\Controllers\Prueba;

Router::init();

Router::group(['prefix' => '/apiv1'], function() {
	Router::group(['prefix' => '/test'], function() {
		Router::post('post', function() {
			$price = "2.844.323,88";
			$prueba = new Prueba();
			echo("Se le pagará la cantidad de COP \${$price} (" . $prueba->numberToString($price)) ." PESOS COLOMBIANOS)";
		});
	});
});

Router::dispatch();