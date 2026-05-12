<?php

namespace Platform\Core\Provider;

use Framework\Container\Container;
use Framework\Core\Context;
use Framework\Core\Provider\ProviderInterface;

class ConfigProvider implements ProviderInterface
{
    public function register(Container $container, Context $context): void
    {
        $app = require $context->path('app/config/app.php');
        $env = require $context->path('app/config/env.php');

        $config = array_merge($app, $env[$context->getEnvironment()]);

        foreach ($config as $key => $value) {
            $container->set("config.{$key}", $value);
        }
    }

    public function boot(Container $container, Context $context): void
    {
        //
    }

    public function priority(): int
    {
        return 10;
    }
}
