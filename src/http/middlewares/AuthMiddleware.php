<?php

namespace Api\Http\Middleware;

use Api\Functions\Security;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class AuthMiddleware
{
	protected $session;

	public function __construct(Session $session)
	{
		$this->session = $session;
	}

	public function handle(Request $request)
	{
		$jwt = $request->headers->get('Authorization');
		if (empty($jwt)) {
			return false;
		}

		$decodedJWT = Security::decodeJWT($jwt);
		if (!$decodedJWT) {
			return false;
		}

		$this->session->set('jwt_data', $decodedJWT);
		return true;
	}
}