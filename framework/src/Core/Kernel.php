<?php

namespace Framework\Core;

use Framework\Container\Container;
use Framework\Core\Exception\ExceptionHandler;
use Framework\Core\Exception\ExceptionHandlerInterface;
use Framework\Http\Middleware\SessionStartMiddleware;
use Framework\Http\Request\Request;
use Framework\Http\Request\RequestDispatcher;
use Framework\Http\Request\RequestFactory;
use Framework\Http\Response\Response;

abstract class Kernel
{
    /** @var Container */
    protected $container;
    /** @var Context */
    protected $context;
    /** @var bool */
    protected $booted = false;
    /** @var array */
    protected $middleware = [
        SessionStartMiddleware::class,
    ];

    public function __construct(string $environment, bool $debug)
    {
        $this->container = new Container();

        $this->context = new Context(
            $this->resolveRoot(),
            $environment,
            $debug
        );

        $this->container->set(Container::class, $this->container);
        $this->container->set(Context::class, $this->context);
    }

    /** @return static */
    public function boot()
    {
        if ($this->booted) {
            return $this;
        }

        $this->registerServices();
        $this->registerExceptionHandler();

        $this->booted = true;

        return $this;
    }

    public function run(?Request $request = null): void
    {
        if (!$this->booted) {
            $this->boot();
        }

        if ($request === null) {
            $request = RequestFactory::createFromGlobals();
        }

        $this->container->set(Request::class, $request);

        try {
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
        return [];
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
        $providers = $this->serviceProviders();

        usort($providers, function ($a, $b) {
            return $a->priority() <=> $b->priority();
        });

        foreach ($providers as $provider) {
            $provider->register($this->container, $this->context);
        }

        foreach ($providers as $provider) {
            $provider->boot($this->container, $this->context);
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
        $dispatcher = $this->container->make(RequestDispatcher::class, [
            'middleware' => $this->middleware,
        ]);

        return $dispatcher->dispatch($request);
    }

    private function handleThrowable(\Throwable $e): Response
    {
        return $this->container->get(ExceptionHandlerInterface::class)->handle($e);
    }
}
