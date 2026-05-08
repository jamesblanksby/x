<?php

namespace Framework\Http\Router;

class RouteCollection
{
    /** @var array */
    private $routes = [];

    public function add(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function forMethod(string $method): array
    {
        $method = strtoupper($method);
        $routes = [];

        foreach ($this->routes as $route) {
            if ($route->method === $method) {
                $routes[] = $route;
            }
        }

        return $routes;
    }

    public function byName(string $name): Route
    {
        foreach ($this->routes as $route) {
            if ($route->name === $name) {
                return $route;
            }
        }

        throw new \RuntimeException("No route named `{$name}`.");
    }

    public function all(): array
    {
        return $this->routes;
    }
}
