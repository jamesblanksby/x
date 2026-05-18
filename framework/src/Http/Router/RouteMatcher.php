<?php

namespace Framework\Http\Router;

class RouteMatcher
{
    public function match(string $method, string $path, RouteCollection $collection): RouteMatch
    {
        $method = strtoupper($method);
        $path = '/' . ltrim(rawurldecode($path), '/');

        $matches = [];

        foreach ($collection->forMethod($method) as $route) {
            $params = $this->test($route, $path);

            if ($params !== null) {
                return RouteMatch::found($route, $params);
            }
        }

        foreach ($collection->all() as $route) {
            if ($route->getMethod() === $method) {
                continue;
            }

            $params = $this->test($route, $path);

            if ($params !== null) {
                $matches[] = $route->getMethod();
            }
        }

        if (!$matches) {
            return RouteMatch::notAllowed(array_unique($matches));
        }

        return RouteMatch::notFound();
    }

    private function test(Route $route, string $path): ?array
    {
        preg_match($route->getRegex(), $path, $matches);

        if (!$matches) {
            return null;
        }

        $params = [];

        foreach ($route->getParamNames() as $a => $name) {
            $match = $matches[$name] ?? null;
            if ($match && $match !== '') {
                $params[$name] = $match;
            } elseif ($route->getParamOptional()[$a]) {
                $params[$name] = null;
            }
        }

        return $params;
    }
}
