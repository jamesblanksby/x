<?php

namespace Platform\Core\Provider;

use Framework\Container\Container;
use Framework\Core\Context;
use Framework\Core\Provider\ProviderInterface;
use Framework\Http\Router\Router;

class RouteProvider implements ProviderInterface
{
    public function register(Container $container, Context $context): void
    {
        //
    }

    public function boot(Container $container, Context $context): void
    {
        $groups = array_merge(
            require dirname(__DIR__, 3) . '/config/route.php',
            $container->get('config.route')
        );

        $router = $container->get(Router::class);

        foreach ($groups as $group) {
            $this->registerGroup($router, $group);
        }
    }

    public function priority(): int
    {
        return 30;
    }

    private function registerGroup(Router $router, array $group): void
    {
        $scope = $group['scope'] ?? [];
        $middleware = $group['middleware'] ?? [];

        foreach ($group['routes'] as $resource => $routes) {
            foreach ($routes as $route) {
                [$method, $path, $handler] = $route;

                $this->registerRoute($router, [
                    'method' => $method,
                    'path' => $path,
                    'handler' => $handler,
                    'resource' => $resource,
                    'scope' => $scope,
                    'middleware' => $middleware,
                ]);
            }
        }
    }

    private function registerRoute(Router $router, array $route): void
    {
        $route = $this->resolveRoute($route);

        $router->add(
            $route['method'],
            $route['path'],
            $route['handler'],
            $route['name'],
            $route['middleware']
        );
    }

    private function resolveRoute(array $route): array
    {
        $path = $this->resolvePath($route['path'], $route['scope']);
        $handler = $this->resolveHandler($route['handler'], $route['scope']);
        $action = $this->resolveAction($handler);
        $name = $this->resolveName($route['resource'], $action, $route['scope']);

        return [
            'method' => $route['method'],
            'path' => $path,
            'handler' => $handler,
            'name' => $name,
            'middleware' => $route['middleware'],
        ];
    }

    private function resolvePath(string $path, array $scope): string
    {
        $path = trim($path, '/');

        if (isset($scope['path'])) {
            $path = trim($scope['path'], '/') . '/' . $path;
            $path = trim($path, '/');
        }

        return '/' . $path;
    }

    private function resolveHandler(string $handler, array $scope): string
    {
        $namespace = $scope['namespace'] ?? null;

        if ($namespace && strpos($handler, '\\') === false) {
            return $namespace . '\\' . $handler;
        }

        return $handler;
    }

    private function resolveAction(string $handler): string
    {
        return explode('::', $handler, 2)[1];
    }

    private function resolveName(string $resource, string $action, array $scope): string
    {
        return implode('.', array_filter([$scope['name'] ?? null, $resource, $action]));
    }
}
