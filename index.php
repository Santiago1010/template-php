<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Allow: GET, POST, PUT, DELETE");
//header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set("America/Bogota");

require_once(__DIR__ . "/vendor/autoload.php");

use Dotenv\Dotenv;

use Api\Http\Router;
use Api\Controllers\Prueba;

$dotenv = Dotenv::createImmutable('C:\wamp64\www\template-php');
$dotenv->load();

Router::init();

Router::group(['prefix' => '/apiv1'], function() {
	Router::group(['prefix' => '/test'], function() {
		Router::get('/get', function(){
			$prueba = new Prueba();
			var_dump($prueba->crearArchivo());
		});
	});
});

Router::dispatch();