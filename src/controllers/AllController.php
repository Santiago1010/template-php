<?php

namespace Api\Controllers;

use Api\Interface\iConstructor;

use Api\Functions\Security;
use Api\Functions\Prueba;

use Api\Traits\Response;
use Api\Traits\Files;
use Api\Traits\Logger;

/**
 * Clase que contendrá todas las funciones y traits.
 */
class AllController implements iConstructor {

	use Response;
	use Files;
	use Logger;

	protected object $request;
	protected Prueba $prueba;
	protected Security $security;

	public function __construct() {
		$this->request = $this->getRequest();
		$this->prueba = new Prueba();
		$this->security = new Security();
	}

	private function getRequest(): object {
		$content = json_decode(file_get_contents("php://input"), true);
        return $content === null ? (object) ($_POST + $_FILES + $_GET) : (object) $content;
	}

}