<?php

namespace Framework\Http\Request;

use Framework\Http\Exception\MethodNotAllowedException;
use Framework\Http\Exception\NotFoundException;
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
        $method = $request->getMethod();
        $path = $request->getRelativePath();

        $result = $this->router->match($method, $path);
        $this->context->setRouteMatch($result);

        if (!$result->isAllowed()) {
            throw new MethodNotAllowedException(sprintf(
                'Method `%s` not allowed. Allowed: %s.',
                $method,
                implode(', ', $result->getAllowed())
            ));
        }

        if (!$result->isMatched()) {
            throw new NotFoundException("No route matched `{$path}`.");
        }

        return $this->executor->execute($request, $result->getRoute());
    }
}
