<?php

namespace Framework\Http\Request;

use Framework\Container\Container;
use Framework\Http\Exception\MethodNotAllowedException;
use Framework\Http\Exception\NotFoundException;
use Framework\Http\Response\Response;
use Framework\Http\Router\Route;
use Framework\Http\Router\Router;

class RequestDispatcher
{
    /** @var Container */
    private $container;
    /** @var RequestHandler */
    private $requestHandler;
    /** @var Router */
    private $router;
    /** @var array */
    private $middleware;

    public function __construct(
        Container $container,
        RequestHandler $requestHandler,
        Router $router,
        array $middleware
    ) {
        $this->container = $container;
        $this->requestHandler = $requestHandler;
        $this->router = $router;
        $this->middleware = $middleware;
    }

    public function dispatch(Request $request): Response
    {
        $path = $request->getRelativePath();

        $result = $this->router->match($request->method, $path);

        if ($result->allowed) {
            throw new MethodNotAllowedException(sprintf(
                'Method `%s` not allowed. Allowed: %s.',
                $request->method,
                implode(', ', $result->allowed)
            ));
        }

        if (!$result->route) {
            throw new NotFoundException("No route matched `{$path}`.");
        }

        $request = $request->withAttribute(Route::class, $result->route);
        $request = $request->withAttributes($result->params);

        $route = $result->route;

        $core = function (Request $request) use ($route): Response {
            return $this->requestHandler->handle($request, $route);
        };

        $middleware = array_merge($this->middleware, $route->middleware);

        $pipeline = array_reduce(array_reverse($middleware), function (callable $next, string $middlewareClass) {
            return function (Request $request) use ($next, $middlewareClass): Response {
                $middleware = $this->container->get($middlewareClass);
                return $middleware->handle($request, $next);
            };
        }, $core);

        return $pipeline($request);
    }
}
