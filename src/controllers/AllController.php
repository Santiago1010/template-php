<?php

namespace Api\Controllers;

use Api\Traits\Response;
use Api\Traits\Files;
use Api\Traits\Logger;

/**
 * Clase que contendrá todas las funciones y traits.
 */
class AllController {

	use Response;
	use Files;
	use Logger;
	
	protected array $request;

	public function __construct() {}

}