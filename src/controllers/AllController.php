<?php

namespace Api\Controllers;

use Api\Interfaces\iConstructor;

use Api\Functions\Security;

use Api\Traits\Response;
use Api\Traits\Files;
use Api\Traits\Logger;
use Api\Traits\Number;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Clase que contendrá todas las funciones y traits.
 */
class AllController extends Security implements iConstructor {

	use Response;
	use Files;
	use Logger;
	use Number;

	protected array $request;

	public function __construct() {
		$session = new Session();
		$this->request = $session->get('clean_request_data');
	}

	public static function jsonParser(array $response): string {
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}

}