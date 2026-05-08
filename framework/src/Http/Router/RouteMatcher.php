<?php

namespace Framework\Http\Router;

class RouteMatcher
{
    public function match(string $method, string $path, RouteCollection $collection): MatchResult
    {
        $method = strtoupper($method);
        $path = '/' . ltrim(rawurldecode($path), '/');

        $matches = [];

        foreach ($collection->forMethod($method) as $route) {
            $params = $this->test($route, $path);

            if ($params !== null) {
                return MatchResult::found($route, $params);
            }
        }

        foreach ($collection->all() as $route) {
            if ($route->method === $method) {
                continue;
            }

            $params = $this->test($route, $path);

            if ($params !== null) {
                $matches[] = $route->method;
            }
        }

        if (!$matches) {
            return MatchResult::methodNotAllowed(array_unique($matches));
        }

        return MatchResult::notFound();
    }

    private function test(Route $route, string $path): ?array
    {
        preg_match($route->regex, $path, $matches);

        if (!$matches) {
            return null;
        }

        $params = [];

        foreach ($route->paramNames as $a => $name) {
            if (isset($matches[$name]) && $matches[$name] !== '') {
                $params[$name] = $matches[$name];
            } elseif ($route->paramOptional[$a]) {
                $params[$name] = null;
            }
        }

        return $params;
    }
}
