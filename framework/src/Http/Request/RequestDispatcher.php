<?php

namespace Framework\Http\Request;

use Framework\Http\Exception\MethodNotAllowedException;
use Framework\Http\Exception\NotFoundException;
use Framework\Http\Response\Response;
use Framework\Http\Router\Route;
use Framework\Http\Router\Router;

class RequestDispatcher
{
    /** @var RequestExecutor */
    private $executor;
    /** @var Router */
    private $router;

    public function __construct(
        RequestExecutor $executor,
        Router $router
    ) {
        $this->executor = $executor;
        $this->router = $router;
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->getMethod();
        $path = $request->getRelativePath();

        $result = $this->router->match($method, $path);

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

        $request = $request->addAttribute(Route::class, $result->getRoute());
        $request = $request->addAttributes($result->getParams());

        return $this->executor->execute($request, $result->getRoute());
    }
}
