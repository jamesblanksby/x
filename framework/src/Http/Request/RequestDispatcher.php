<?php

namespace Framework\Http\Request;

use Framework\Http\Response\Response;
use Framework\Http\Router\Router;

class RequestDispatcher
{
    /** @var RequestContext */
    private $context;
    /** @var RequestExecutor */
    private $executor;
    /** @var Router */
    private $router;

    public function __construct(
        RequestContext $context,
        RequestExecutor $executor,
        Router $router
    ) {
        $this->context = $context;
        $this->executor = $executor;
        $this->router = $router;
    }

    public function dispatch(Request $request): Response
    {
        $routeMatch = $this->router->match($request->getMethod(), $request->getRelativePath());
        $this->context->setRouteMatch($routeMatch);

        return $this->executor->execute($request, $routeMatch);
    }
}
