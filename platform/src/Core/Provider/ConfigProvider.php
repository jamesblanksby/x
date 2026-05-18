<?php

namespace Platform\Core\Provider;

use Framework\Container\Container;
use Framework\Core\KernelConfig;
use Framework\Core\Provider\ProviderInterface;

class ConfigProvider implements ProviderInterface
{
    public function register(Container $container): void
    {
        $kernelConfig = $container->get(KernelConfig::class);

        $app = require $kernelConfig->path('app/config/app.php');
        $env = require $kernelConfig->path('app/config/env.php');

        $config = array_merge($app, $env[$kernelConfig->getEnvironment()]);

        foreach ($config as $key => $value) {
            $container->set("config.{$key}", $value);
        }
    }

    public function boot(Container $container): void
    {
        // no-op
    }

    public function priority(): int
    {
        return 10;
    }
}
