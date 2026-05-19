<?php

namespace Framework\Http\Request;

use Framework\Container\Container;
use Framework\Http\Exception\MethodNotAllowedException;
use Framework\Http\Exception\NotFoundException;
use Framework\Http\Middleware\MiddlewareStack;
use Framework\Http\Response\Response;
use Framework\Http\Router\RouteMatch;
use Framework\Http\Router\Router;

class RequestDispatcher
{
    /** @var Container */
    private $container;
    /** @var Router */
    private $router;
    /** @var RequestContext */
    private $context;
    /** @var RequestHandler */
    private $handler;

    public function __construct(
        Container $container,
        RequestContext $context,
        RequestHandler $handler,
        Router $router
    ) {
        $this->container = $container;
        $this->context = $context;
        $this->handler = $handler;
        $this->router = $router;
    }

    public function dispatch(Request $request): Response
    {
        $routeMatch = $this->router->match($request->getMethod(), $request->getRelativePath());
        $this->context->setRouteMatch($routeMatch);

        $middleware = $this->resolveMiddleware($routeMatch);

        $controller = function (Request $request) use ($routeMatch): Response {
            if (!$routeMatch->isAllowed()) {
                throw new MethodNotAllowedException(sprintf(
                    'Method `%s` not allowed. Allowed: %s.',
                    $request->getMethod(),
                    implode(', ', $routeMatch->getAllowed())
                ));
            }

            if (!$routeMatch->isMatched()) {
                throw new NotFoundException("No route matched `{$request->getRelativePath()}`.");
            }

            return $this->handler->handle($request, $routeMatch->getRoute());
        };

        return $this->pipe($request, $controller, $middleware);
    }

    private function resolveMiddleware(RouteMatch $routeMatch): array
    {
        $classes = $this->container->get(MiddlewareStack::class)->all();

        if ($routeMatch->isMatched() && $routeMatch->isAllowed()) {
            $classes = array_merge($classes, $routeMatch->getRoute()->getMiddleware());
        }

        $middleware = [];
        foreach ($classes as $class) {
            $middleware[] = $this->container->get($class);
        }

        return $middleware;
    }

    private function pipe(Request $request, callable $controller, array $middleware): Response
    {
        $core = $controller;

        foreach (array_reverse($middleware) as $layer) {
            $next = $core;

            $core = function (Request $request) use ($layer, $next): Response {
                return $layer->handle($request, $next);
            };
        }

        return $core($request);
    }
}
