<?php

namespace Framework\Core\Provider;

use Framework\Container\Container;
use Framework\View\View;

class ViewProvider implements ProviderInterface
{
    public function register(Container $container): void
    {
        $config = require dirname(__DIR__, 3) . '/config/view.php';

        $view = $container->get(View::class);

        foreach ($config['extensions'] as $extensionClass) {
            $extension = $container->get($extensionClass);
            $view->registerExtension($extension);
        }
    }

    public function boot(Container $container): void
    {
        // no-op
    }

    public function priority(): int
    {
        return -30;
    }
}
