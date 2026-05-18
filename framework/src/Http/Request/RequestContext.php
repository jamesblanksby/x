<?php

namespace Framework\Http\Request;

use Framework\Http\Router\RouteMatch;
use Framework\Http\Session\Session;

class RequestContext
{
    /** @var ?Request */
    private $request = null;
    /** @var ?Session */
    private $session = null;
    /** @var ?RouteMatch */
    private $routeMatch = null;

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function getRequest(): Request
    {
        if ($this->request !== null) {
            return $this->request;
        }

        throw new \RuntimeException('Request not available yet.');
    }

    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    public function getSession(): Session
    {
        if ($this->session !== null) {
            return $this->session;
        }

        throw new \RuntimeException('Session not available yet.');
    }

    public function setRouteMatch(RouteMatch $routeMatch): void
    {
        $this->routeMatch = $routeMatch;
    }

    public function getRouteMatch(): RouteMatch
    {
        if ($this->routeMatch !== null) {
            return $this->routeMatch;
        }

        throw new \RuntimeException('Route match not available yet.');
    }
}
