<?php

namespace Framework\Http\Router;

class Route
{
    /** @var string */
    private $method;
    /** @var string */
    private $path;
    /** @var string */
    private $regex;
    /** @var array */
    private $paramNames;
    /** @var array */
    private $paramOptional;
    /** @var string */
    private $handler;
    /** @var string */
    private $name;
    /** @var array */
    private $middleware;

    public function __construct(
        string $method,
        string $path,
        string $regex,
        array $paramNames,
        array $paramOptional,
        string $handler,
        string $name,
        array $middleware
    ) {
        $this->method = $method;
        $this->path = $path;
        $this->regex = $regex;
        $this->paramNames = $paramNames;
        $this->paramOptional = $paramOptional;
        $this->handler = $handler;
        $this->name = $name;
        $this->middleware = $middleware;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getRegex(): string
    {
        return $this->regex;
    }

    public function getParamNames(): array
    {
        return $this->paramNames;
    }

    public function getParamOptional(): array
    {
        return $this->paramOptional;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }
}
