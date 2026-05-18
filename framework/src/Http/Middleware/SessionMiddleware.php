<?php

namespace Framework\Http\Middleware;

use Framework\Http\Request\Request;
use Framework\Http\Request\RequestContext;
use Framework\Http\Response\Response;
use Framework\Http\Session\Session;

class SessionMiddleware implements MiddlewareInterface
{
    /** @var RequestContext */
    private $requestContext;
    /** @var Session */
    private $session;

    public function __construct(
        RequestContext $requestContext,
        Session $session
    ) {
        $this->requestContext = $requestContext;
        $this->session = $session;
    }

    public function handle(Request $request, callable $next): Response
    {
        $this->session->start();
        $this->requestContext->setSession($this->session);

        return $next($request);
    }
}
