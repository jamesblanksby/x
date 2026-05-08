<?php

namespace Platform\Core\Provider;

use Framework\Container\Container;
use Framework\Core\Context;
use Framework\Core\Provider\ProviderInterface;
use Framework\Database\Config;

class DatabaseProvider implements ProviderInterface
{
    public function register(Container $container, Context $context): void
    {
        $database = $container->get('config.database');

        $config = new Config([
            'driver' => $database['driver'],
            'host' => $database['host'],
            'database' => $database['name'],
            'charset' => $database['charset'],
            'username' => $database['username'],
            'password' => $database['password'],
        ]);

        $container->set(Config::class, $config);
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
