<?php

namespace Api\Controllers;

use Api\Interfaces\iConstructor;

use Api\Functions\Security;

use Api\Traits\Response;
use Api\Traits\Files;
use Api\Traits\Logger;

/**
 * Clase que contendrá todas las funciones y traits.
 */
class AllController extends Security implements iConstructor {

	use Response;
	use Files;
	use Logger;

	protected object $request;

	public function __construct() {
		$this->request = $this->getRequest();
	}

	private function getRequest(): object {
		$content = json_decode(file_get_contents("php://input"), true);
        return $content === null ? (object) ($_POST + $_FILES + $_GET) : (object) $content;
	}

	protected function jsonParser(array $response): string {
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}

}