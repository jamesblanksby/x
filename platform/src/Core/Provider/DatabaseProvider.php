<?php

namespace Platform\Core\Provider;

use Framework\Container\Container;
use Framework\Core\Provider\ProviderInterface;
use Framework\Database\ConnectionConfig;

class DatabaseProvider implements ProviderInterface
{
    public function register(Container $container): void
    {
        $database = $container->get('config.database');

        $config = new ConnectionConfig([
            'driver' => $database['driver'],
            'host' => $database['host'],
            'database' => $database['name'],
            'charset' => $database['charset'],
            'username' => $database['username'],
            'password' => $database['password'],
        ]);

        $container->set(ConnectionConfig::class, $config);
    }

    public function boot(Container $container): void
    {
        // no-op
    }

    public function priority(): int
    {
        return 30;
    }
}
