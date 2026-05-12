<?php

namespace Platform\Module\Admin\Middleware;

use Framework\Http\Middleware\MiddlewareInterface;
use Framework\Http\Request\Request;
use Framework\Http\Response\RedirectResponse;
use Framework\Http\Response\Response;
use Framework\Http\Router\Route;
use Framework\Http\Router\UrlGenerator;
use Framework\Security\AuthenticatedUser;
use Platform\Security\Authenticator;

class AuthMiddleware implements MiddlewareInterface
{
    /** @var Authenticator */
    private $authenticator;
    /** @var UrlGenerator */
    private $urlGenerator;

    private const PUBLIC_ROUTES = [
        'admin.auth.login',
        'admin.auth.authenticate',
        'admin.auth.logout',
    ];

    public function __construct(
        Authenticator $authenticator,
        UrlGenerator $urlGenerator
    ) {
        $this->authenticator = $authenticator;
        $this->urlGenerator = $urlGenerator;
    }

    public function handle(Request $request, callable $next): Response
    {
        $user = $this->authenticator->user();

        if ($this->requiresAuthentication($request) && !$user) {
            $url = $this->urlGenerator->generate('admin.auth.login', [
                'redirect' => $request->getUrl(),
            ], true);

            return new RedirectResponse($url);
        }

        if ($user) {
            $request = $request->withAttribute(AuthenticatedUser::class, $user);
        }

        return $next($request);
    }

    private function requiresAuthentication(Request $request): bool
    {
        $route = $request->getAttribute(Route::class);

        if (!$route) {
            return false;
        }

        return !in_array($route->name, self::PUBLIC_ROUTES);
    }
}
