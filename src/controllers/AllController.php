<?php

namespace Api\Controllers;

use Api\Functions\Logs;

/**
 * Clase que contendrá todas las funciones y traits.
 */
class AllController {

	use Api\Traits\Response;

	protected ?Logs $log = null;
	
	protected function __construct() {
		$this->log = new Logs();
	}

}