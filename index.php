<?php

date_default_timezone_set("America/Bogota");

require_once(__DIR__ . "/vendor/autoload.php");

use Dotenv\Dotenv;

use Api\Controllers\Prueba;

$dotenv = Dotenv::createImmutable('C:\wamp64\www\template-php');
$dotenv->load();

$p = new Prueba();
$p->crearArchivo();