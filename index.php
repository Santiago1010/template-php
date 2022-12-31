<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Allow: GET, POST, PUT, DELETE");
//header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set("America/Bogota");

require_once(__DIR__ . "/vendor/autoload.php");

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('C:\wamp64\www\template-php');
$dotenv->load();

use Api\Http\Router;

// Importar controladores.
use Api\Controllers\UsersController;
use Api\Controllers\Prueba;

Router::init();

Router::group(['prefix' => '/apiv1'], function() {
	Router::group(['prefix' => '/test'], function() {
		Router::get('/get', function(){
			$prueba = new Prueba();
			var_dump($prueba->readColumns());
		});

		Router::post('/user', function() {
			$users = new UsersController();
			var_dump($users->createuser());
		});

		Router::post('/security', function() {
			$prueba = new Prueba();
			var_dump($prueba->passwordString());
		});
	});
});

Router::dispatch();