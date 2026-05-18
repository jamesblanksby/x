<?php

namespace Framework\Core\Provider;

use Framework\Container\Container;

interface ProviderInterface
{
    public function register(Container $container): void;

    public function boot(Container $container): void;

    public function priority(): int;
}
