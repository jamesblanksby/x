<?php

namespace Framework\Http\Request;

use Framework\Container\Container;
use Framework\Http\Middleware\MiddlewareStack;
use Framework\Http\Middleware\Pipeline;
use Framework\Http\Response\Response;
use Framework\Http\Router\Route;

class RequestExecutor
{
    /** @var Container */
    private $container;
    /** @var Pipeline */
    private $pipeline;
    /** @var RequestHandler */
    private $handler;

    public function __construct(
        Container $container,
        Pipeline $pipeline,
        RequestHandler $handler
    ) {
        $this->container = $container;
        $this->handler = $handler;
        $this->pipeline = $pipeline;
    }

    public function execute(Request $request, Route $route): Response
    {
        $controller = function (Request $request) use ($route) {
            return $this->handler->handle($request, $route);
        };

        $middlewareClasses = array_merge(
            $this->container->get(MiddlewareStack::class)->all(),
            $route->getMiddleware()
        );

        $middleware = [];
        foreach ($middlewareClasses as $middlewareClass) {
            $middleware[] = $this->container->get($middlewareClass);
        }

        return $this->pipeline->process(
            $request,
            $controller,
            $middleware
        );
    }
}
