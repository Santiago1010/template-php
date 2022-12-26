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

	protected $request;

	public function __construct() {
		$this->request = $this->getRequest();
	}

	private function getRequest(): object {
		$content = json_decode(file_get_contents("php://input"), true);
        return $content === null ? (object) ($_POST + $_FILES + $_GET) : (object) $content;
	}

}