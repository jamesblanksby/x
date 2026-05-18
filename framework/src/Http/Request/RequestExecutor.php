<?php

namespace Framework\Http\Request;

use Framework\Container\Container;
use Framework\Http\Exception\MethodNotAllowedException;
use Framework\Http\Exception\NotFoundException;
use Framework\Http\Middleware\MiddlewareStack;
use Framework\Http\Middleware\Pipeline;
use Framework\Http\Response\Response;
use Framework\Http\Router\RouteMatch;

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

    public function execute(Request $request, RouteMatch $routeMatch): Response
    {
        $controller = function (Request $request) use ($routeMatch) {
            $method = $request->getMethod();
            $path = $request->getRelativePath();

            if (!$routeMatch->isAllowed()) {
                throw new MethodNotAllowedException(sprintf(
                    'Method `%s` not allowed. Allowed: %s.',
                    $method,
                    implode(', ', $routeMatch->getAllowed())
                ));
            }

            if (!$routeMatch->isMatched()) {
                throw new NotFoundException("No route matched `{$path}`.");
            }

            return $this->handler->handle($request, $routeMatch->getRoute());
        };

        $middlewareClasses = $this->container->get(MiddlewareStack::class)->all();

        if ($routeMatch->isMatched() && $routeMatch->isAllowed()) {
            $middlewareClasses = array_merge($middlewareClasses, $routeMatch->getRoute()->getMiddleware());
        }

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
