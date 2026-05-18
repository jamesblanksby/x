<?php

namespace Framework\Core\Provider;

use Framework\Container\Container;
use Framework\Http\Middleware\MiddlewareStack;
use Framework\Http\Middleware\SessionMiddleware;

class MiddlewareProvider implements ProviderInterface
{
    public function register(Container $container): void
    {
        $container->set(MiddlewareStack::class, function () {
            return new MiddlewareStack([
                SessionMiddleware::class,
            ]);
        });
    }

    public function boot(Container $container): void
    {
        // no-op
    }

    public function priority(): int
    {
        return -20;
    }
}
