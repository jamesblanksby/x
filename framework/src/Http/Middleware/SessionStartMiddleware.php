<?php

namespace Framework\Http\Middleware;

use Framework\Http\Request\Request;
use Framework\Http\Response\Response;
use Framework\Http\Session\Session;

class SessionStartMiddleware implements MiddlewareInterface
{
    /** @var Session */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function handle(Request $request, callable $next): Response
    {
        $this->session->start();
        $request->setSession($this->session);

        return $next($request);
    }
}
