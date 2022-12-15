<?php

namespace Api\Functions;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

/**
 * Clase que controla todos los logs de la API.
 */
class Logs {

	protected ?Logger $log = null;

	public function __construct() {
		$this->log = new Logger('my_logger');
	}

}