<?php

namespace Api\Http;

use Closure;
use Symfony\Component\HttpFoundation\Request;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;

class Router {
	protected static $router;
	protected static $request;

	public static function init() {
		self::$router = new RouteCollector();
	}

	public static function get(string $uri, $function, array $options = []): void {
		self::$router->get($uri, function() use ($function) {
			return $function(self::$request);
		}, $options);
	}

	public static function post(string $uri, $function, array $options = []): void {
		self::$router->post($uri, function() use ($function) {
			return $function(self::$request);
		}, $options);
	}

	public static function put(string $uri, $function, array $options = []): void {
		self::$router->put($uri, function() use ($function) {
			return $function(self::$request);
		}, $options);
	}

	public static function delete(string $uri, $function, array $options = []): void {
		self::$router->delete($uri, function() use ($function) {
			return $function(self::$request);
		}, $options);
	}

	public static function any(string $uri, $function, array $options = []): void {
		self::$router->any($uri, function() use ($function) {
			return $function(self::$request);
		}, $options);
	}

	public static function head(string $uri, $function, array $options = []): void {
		self::$router->head($uri, function() use ($function) {
			return $function(self::$request);
		}, $options);
	}

	public static function options(string $uri, $function, array $options = []): void {
		self::$router->options($uri, function() use ($function) {
			return $function(self::$request);
		}, $options);
	}

	public static function patch(string $uri, $function, array $options = []): void {
		self::$router->patch($uri, function() use ($function) {
			return $function(self::$request);
		}, $options);
	}

	public static function group(array $options, Closure $closure): void {
		self::$router->group($options, function() use ($closure) {
			return $closure(self::$request);
		});
	}


	public static function filter(string $name, Closure $closure): void {
		self::$router->filter($name, function() use ($closure) {
			return $closure(self::$request);
		});
	}

	public static function dispatch(): void {
		try {
			$dispatcher = new Dispatcher(self::$router->getData());
			$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], implode('/', array_slice(explode('/', $_SERVER['REQUEST_URI']), 2)));
			echo $response;
		} catch (HttpRouteNotFoundException $e) {
            // Manejo de excepción para rutas no encontradas
            echo $e->getMessage();
		} catch (HttpMethodNotAllowedException $e) {
            // Manejo de excepción para métodos HTTP no permitidos
            echo $e->getMessage();
		}
	}
}