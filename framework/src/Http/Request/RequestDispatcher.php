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

    public function __construct(
        Container $container,
        RequestHandler $requestHandler,
        Router $router
    ) {
        $this->container = $container;
        $this->requestHandler = $requestHandler;
        $this->router = $router;
    }

    public function dispatch(Request $request): Response
    {
        $path = $request->getRelativePath();

        $result = $this->router->match($request->getMethod(), $path);

        if (!$result->isAllowed()) {
            throw new MethodNotAllowedException(sprintf(
                'Method `%s` not allowed. Allowed: %s.',
                $request->getMethod(),
                implode(', ', $result->getAllowed())
            ));
        }

        if (!$result->isMatched()) {
            throw new NotFoundException("No route matched `{$path}`.");
        }

        $request = $request->withAttribute(Route::class, $result->getRoute());
        $request = $request->withAttributes($result->getParams());

        $route = $result->getRoute();

        $core = function (Request $request) use ($route): Response {
            return $this->requestHandler->handle($request, $route);
        };

        $middleware = array_reverse($route->getMiddleware());

        $pipeline = array_reduce($middleware, function (callable $next, string $middlewareClass) {
            return function (Request $request) use ($next, $middlewareClass): Response {
                $middleware = $this->container->get($middlewareClass);
                return $middleware->handle($request, $next);
            };
        }, $core);

        return $pipeline($request);
    }
}
