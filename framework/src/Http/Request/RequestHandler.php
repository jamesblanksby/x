<?php

namespace Framework\Http\Request;

use Framework\Http\Response\JsonResponse;
use Framework\Http\Response\Response;
use Framework\Http\Router\Route;

class RequestHandler
{
    /** @var HandlerResolver */
    private $handlerResolver;
    /** @var ParameterResolver */
    private $parameterResolver;

    public function __construct(
        HandlerResolver $handlerResolver,
        ParameterResolver $parameterResolver
    ) {
        $this->handlerResolver = $handlerResolver;
        $this->parameterResolver = $parameterResolver;
    }

    public function handle(Request $request, Route $route): Response
    {
        [$controller, $methodName] = $this->handlerResolver->resolve($route->handler);

        $method = new \ReflectionMethod($controller, $methodName);
        $args = $this->parameterResolver->resolveMethodArgs($method, $request);

        $result = $controller->{$methodName}(...$args);

        if ($result instanceof Response) {
            return $result;
        }

        if (is_array($result) || is_object($result)) {
            return new JsonResponse($result);
        }

        return new Response($result);
    }
}
