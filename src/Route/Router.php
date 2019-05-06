<?php

namespace EenmaalAndermaal\Route;

use EenmaalAndermaal\Request\RequestMethod;
use EenmaalAndermaal\Request\Response;

class Router
{

    /**
     * @var Route[] $routes
     */
    private $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }


    public function getRoute(string $link, RequestMethod $method): Route
    {
        $routes = array_filter($this->routes, function(Route $route) use ($link, $method) {
            return $route->match($link, $method);
        });
        $routes = array_values($routes);
        if (count($routes)) {
            return $routes[0];
        }
        return new Route($link, RequestMethod::GET(), function () use ($method, $link) {
            return new Response(404, "URI not found. Check the documentation for all available API calls", [
                "uri" => $link,
                "method" => $method->value
            ]);
        });
    }


}