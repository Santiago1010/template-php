<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Closure;

class AuthAttempt {

	private $session;
	private $maxAttempts = 3;
	private $decayMinutes = 3;

	public function __construct(Session $session) {
		$this->session = $session;
	}

	public function handle(Request $request, Closure $next) {
		if ($this->hasTooManyLoginAttempts($request)) {
			return $this->buildResponse('Too many login attempts.', 403);
		}

		$response = $next($request);

		if ($response->getStatusCode() === 401) {
			$this->incrementLoginAttempts($request);
		}

		return $response;
	}

	private function incrementLoginAttempts(Request $request) {
		$key = $this->getLoginAttemptsCacheKey($request);
		$this->session->put($key, $this->attempts($request) + 1, $this->decayMinutes);
	}

	private function hasTooManyLoginAttempts(Request $request) {
		return $this->attempts($request) >= $this->maxAttempts;
	}

	private function attempts(Request $request) {
		$key = $this->getLoginAttemptsCacheKey($request);
		return $this->session->get($key, 0);
	}

	private function getLoginAttemptsCacheKey(Request $request) {
		return 'login_attempts_' . $request->getClientIp();
	}

	private function buildResponse($message, $status) {
		return new Response($message, $status);
	}

}