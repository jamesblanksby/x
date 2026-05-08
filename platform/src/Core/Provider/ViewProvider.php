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
        $config = array_merge_recursive(
            require dirname(__DIR__, 3) . '/config/view.php',
            $container->get('config.view')
        );

        $view = $container->get(View::class);

        foreach ($config['paths'] as $path) {
            $view->addPath($path);
        }

        foreach ($config['extensions'] as $extensionClass) {
            $extension = $container->get($extensionClass);
            $view->registerExtension($extension);
        }
    }

    public function boot(Container $container, Context $context): void
    {
        //
    }

    public function priority(): int
    {
        return 40;
    }
}
