<?php

namespace Framework\Core;

use Framework\Container\Container;
use Framework\Core\Exception\ExceptionHandler;
use Framework\Core\Exception\ExceptionHandlerInterface;
use Framework\Core\Provider\MiddlewareProvider;
use Framework\Core\Provider\ViewProvider;
use Framework\Http\Request\Request;
use Framework\Http\Request\RequestContext;
use Framework\Http\Request\RequestDispatcher;
use Framework\Http\Request\RequestFactory;
use Framework\Http\Response\Response;

abstract class Kernel
{
    /** @var Container */
    protected $container;
    /** @var KernelConfig */
    protected $config;
    /** @var bool */
    protected $booted = false;

    public function __construct(string $environment, bool $debug)
    {
        $this->container = new Container();

        $this->config = new KernelConfig(
            $this->resolveRoot(),
            $environment,
            $debug
        );

        $this->container->set(Container::class, $this->container);
        $this->container->set(KernelConfig::class, $this->config);
    }

    /** @return static */
    public function boot()
    {
        if ($this->booted) {
            return $this;
        }

        $this->registerExceptionHandler();
        $this->registerServices();

        $this->booted = true;

        return $this;
    }

    public function run(?Request $request = null): void
    {
        try {
            if (!$this->booted) {
                $this->boot();
            }

            if ($request === null) {
                $request = RequestFactory::createFromGlobals();
            }

            $this->container->get(RequestContext::class)->setRequest($request);

            $response = $this->dispatchHttp($request);
        } catch (\Throwable $e) {
            $response = $this->handleThrowable($e);
        }

        try {
            $response->send();
        } catch (\Throwable $e) {
            $response = $this->handleThrowable($e);
            $response->send();
        }
    }

    protected function serviceProviders(): array
    {
        return [
            MiddlewareProvider::class,
            ViewProvider::class,
        ];
    }

    protected function exceptionHandler(): ExceptionHandlerInterface
    {
        return $this->container->get(ExceptionHandler::class);
    }

    private function registerExceptionHandler(): void
    {
        if (!$this->container->has(ExceptionHandlerInterface::class)) {
            $handler = $this->exceptionHandler();
            $this->container->set(ExceptionHandlerInterface::class, $handler);
        }
    }

    private function registerServices(): void
    {
        $providers = [];
        foreach ($this->serviceProviders() as $providerClass) {
            $providers[] = $this->container->get($providerClass);
        }

        usort($providers, function ($a, $b) {
            return $a->priority() <=> $b->priority();
        });

        foreach ($providers as $provider) {
            $provider->register($this->container);
        }

        foreach ($providers as $provider) {
            $provider->boot($this->container);
        }
    }

    private function resolveRoot(): string
    {
        $directory = dirname((new \ReflectionObject($this))->getFileName());

        while (!is_file($directory . '/composer.json')) {
            $parent = dirname($directory);
            if ($directory === $parent) {
                break;
            }
            $directory = $parent;
        }

        return $directory;
    }

    private function dispatchHttp(Request $request): Response
    {
        $dispatcher = $this->container->get(RequestDispatcher::class);

        return $dispatcher->dispatch($request);
    }

    private function handleThrowable(\Throwable $e): Response
    {
        return $this->container->get(ExceptionHandlerInterface::class)->handle($e);
    }
}
