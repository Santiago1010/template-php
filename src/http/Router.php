<?php

namespace Api\Http;

use Closure;
use Symfony\Component\HttpFoundation\Request;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;

class Router {

    public static RouteCollector $routes;
    public static string $prefix;
    public static array $middlewares = [];

    public static function init() {
        self::$routes ??= new RouteCollector();
    }

    public static function addRoutes($method, $route, $callback, $middleware = []) {
    	self::init();

        self::$routes->addRoute($method, $route, $callback);
        if (!empty($middleware)) {
            self::$routes->addMiddleware($route, $middleware);
        }
    }

    public static function group($prefix, $callback, $middlewares = []) {
        self::init();

        self::$routes->group($prefix, function($route) use ($middlewares, $callback) {
            foreach ($middlewares as $middleware) {
                $route->before($middleware);
            }
            $callback($route);
        });
    }

    public static function get($route, $callback, $middleware = []) {
    	self::init();

        self::addRoutes('GET', $route, $callback, $middleware);
    }

    public static function post($route, $callback, $middleware = []) {
    	self::init();

        self::addRoutes('POST', $route, $callback, $middleware);
    }

    public static function put($route, $callback, $middleware = []) {
    	self::init();

        self::addRoutes('PUT', $route, $callback, $middleware);
    }

    public static function patch($route, $callback, $middleware = []) {
    	self::init();

        self::addRoutes('PATCH', $route, $callback, $middleware);
    }

    public static function delete($route, $callback, $middleware = []) {
    	self::init();

        self::addRoutes('DELETE', $route, $callback, $middleware);
    }

    public static function options($route, $callback, $middleware = []) {
    	self::init();

        self::addRoutes('OPTIONS', $route, $callback, $middleware);
    }

    public static function dispatch(Request $request) {
        $dispatcher = new Dispatcher(self::$routes->getData());

        try {
            $response = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
            return $response;
        } catch (HttpRouteNotFoundException $e) {
            return $e->getMessage();
        } catch (HttpMethodNotAllowedException $e) {
            return $e->getMessage();
        }
    }

}