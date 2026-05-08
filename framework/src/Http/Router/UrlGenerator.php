<?php

namespace Framework\Http\Router;

use Framework\Container\Container;
use Framework\Http\Request\Request;

class UrlGenerator
{
    /** @var RouteCollection */
    private $collection;
    /** @var Container */
    private $container;

    private const PARAM_REGEX = '/\{(\w+)(?::[^}]+)?\}(\?)?/';

    public function __construct(
        RouteCollection $collection,
        Container $container
    ) {
        $this->collection = $collection;
        $this->container = $container;
    }

    public function generate(string $name, array $params = [], bool $absolute = false): string
    {
        $route = $this->collection->byName($name);

        $used = [];

        $path = $this->buildPath($route, $params, $used);
        $path = $this->appendQueryString($path, $params, $used);

        if (!$absolute) {
            return $path;
        }

        return $this->buildUrl($path);
    }

    private function buildPath(Route $route, array $params, array &$used): string
    {
        $callback = function (array $matches) use ($route, $params, &$used): string {
            $name = $matches[1];
            $optional = ($matches[2] ?? '') === '?';

            if (!array_key_exists($name, $params) || $params[$name] === null) {
                if ($optional) {
                    return '';
                }

                throw new \RuntimeException("Missing required parameter `{$name}` for route `{$route->name}`.");
            }

            $used[] = $name;

            return (string) $params[$name];
        };

        return preg_replace_callback(self::PARAM_REGEX, $callback, $route->path);
    }

    private function appendQueryString(string $path, array $params, array $used): string
    {
        $query = array_diff_key($params, array_flip($used));

        if (!$query) {
            return $path;
        }

        return $path . '?' . http_build_query($query);
    }

    private function buildUrl(string $path): string
    {
        $request = $this->container->get(Request::class);

        return rtrim($request->getBaseUrl(), '/') . '/' . ltrim($path, '/');
    }
}
