<?php

namespace Api\Controllers;

use Api\Functions\Logs;

/**
 * Clase que contendrá todas las funciones y traits.
 */
class AllController {

	private ?Logs $log = null;
	
	public function __construct() {
		$this->log = new Logs();
	}

}