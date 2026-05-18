<?php

namespace Platform\Module\Admin\Middleware;

use Framework\Http\Middleware\MiddlewareInterface;
use Framework\Http\Request\Request;
use Framework\Http\Request\RequestContext;
use Framework\Http\Response\RedirectResponse;
use Framework\Http\Response\Response;
use Framework\Http\Router\Router;
use Platform\Security\Authenticator;

class AuthMiddleware implements MiddlewareInterface
{
    /** @var Authenticator */
    private $authenticator;
    /** @var RequestContext */
    private $requestContext;
    /** @var Router */
    private $router;

    private const PUBLIC_ROUTES = [
        'admin.auth.login',
        'admin.auth.authenticate',
        'admin.auth.logout',
    ];

    public function __construct(
        Authenticator $authenticator,
        RequestContext $requestContext,
        Router $router
    ) {
        $this->authenticator = $authenticator;
        $this->requestContext = $requestContext;
        $this->router = $router;
    }

    public function handle(Request $request, callable $next): Response
    {
        $user = $this->authenticator->getUser();

        if ($this->requiresAuthentication() && !$user) {
            $url = $this->router->url('admin.auth.login', [
                'redirect' => $request->getUrl(),
            ], true);

            return new RedirectResponse($url);
        }

        return $next($request);
    }

    private function requiresAuthentication(): bool
    {
        $route = $this->requestContext->getRouteMatch()->getRoute();

        if ($route === null) {
            return false;
        }

        return !in_array($route->getName(), self::PUBLIC_ROUTES);
    }
}
