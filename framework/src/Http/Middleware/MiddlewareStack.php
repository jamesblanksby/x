<?php

namespace Framework\Http\Middleware;

class MiddlewareStack
{
    /** @var array */
    private $middleware = [];

    public function __construct(array $middleware = [])
    {
        $this->middleware = $middleware;
    }

    public function all(): array
    {
        return $this->middleware;
    }

    public function prepend(string $middleware): void
    {
        array_unshift($this->middleware, $middleware);
    }

    public function push(string $middleware): void
    {
        $this->middleware[] = $middleware;
    }
}
