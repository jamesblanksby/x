<?php

namespace Framework\Core\Provider;

use Framework\Container\Container;
use Framework\Core\Context;

interface ProviderInterface
{
    public function register(Container $container, Context $context): void;

    public function boot(Container $container, Context $context): void;

    public function priority(): int;
}
