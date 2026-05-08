<?php

namespace Platform\Core\Provider;

use Framework\Container\Container;
use Framework\Core\Context;
use Framework\Core\Provider\ProviderInterface;
use Framework\View\View;

class ViewProvider implements ProviderInterface
{
    public function register(Container $container, Context $context): void
    {
        $paths = [
            dirname(__DIR__, 3) . '/template/',
            $container->get('config.view')['path'],
        ];

        $view = new View();

        foreach ($paths as $path) {
            $view->add($path);
        }

        $container->set(View::class, $view);
    }

    public function boot(Container $container, Context $context): void
    {
        //
    }

    public function priority(): int
    {
        return 20;
    }
}
