<?php

namespace Framework\Http\Request;

use Framework\Container\Container;
use Framework\Controller\Controller;
use Framework\Http\Exception\HttpException;

class HandlerResolver
{
    /** @var Container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function resolve(string $handler): array
    {
        [$controllerName, $methodName] = $this->parseHandler($handler);

        $controller = $this->container->get($controllerName);

        if (!method_exists($controller, $methodName)) {
            throw new HttpException(500, "Controller method `{$handler}` not found.");
        }

        if ($controller instanceof Controller) {
            $controller->setContainer($this->container);
        }

        return [$controller, $methodName];
    }

    private function parseHandler(string $handler): array
    {
        if (strpos($handler, '::') === false) {
            throw new HttpException(500, "Invalid handler format `{$handler}`. Expected Class::method.");
        }

        return explode('::', $handler, 2);
    }
}
