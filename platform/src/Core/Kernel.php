<?php

namespace Platform\Core;

use Framework\Core\Exception\ExceptionHandlerInterface;
use Framework\Core\Kernel as FrameworkKernel;
use Platform\Core\Exception\ExceptionHandler;
use Platform\Core\Provider\ConfigProvider;
use Platform\Core\Provider\DatabaseProvider;
use Platform\Core\Provider\RouteProvider;
use Platform\Core\Provider\ViewProvider;

class Kernel extends FrameworkKernel
{
    public function __construct()
    {
        $environment = $this->detectEnvironment();
        $debug = $environment !== 'live';

        parent::__construct($environment, $debug);
    }

    protected function exceptionHandler(): ExceptionHandlerInterface
    {
        return $this->container->get(ExceptionHandler::class);
    }

    protected function serviceProviders(): array
    {
        return array_merge(parent::serviceProviders(), [
            ConfigProvider::class,
            DatabaseProvider::class,
            RouteProvider::class,
            ViewProvider::class,
        ]);
    }

    private function detectEnvironment(): string
    {
        $environment = getenv('ENVIRONMENT');

        if ($environment) {
            return $environment;
        }

        if (getenv('DOCKER')) {
            return 'local';
        }

        if (strpos($_SERVER['SERVER_NAME'] ?? '', 'engine.work') !== false) {
            return 'develop';
        }

        return 'live';
    }
}
