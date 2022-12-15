<?php

require_once(__DIR__ . "/vendor/autoload.php");

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('C:\wamp64\www\template-php');
$dotenv->load();

echo "Hola, mundo.";