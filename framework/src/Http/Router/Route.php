<?php

namespace Framework\Http\Router;

use Framework\Support\ImmutableObject;

class Route extends ImmutableObject
{
    /** @var string */
    public $method;
    /** @var string */
    public $path;
    /** @var string */
    public $regex;
    /** @var array */
    public $paramNames;
    /** @var array */
    public $paramOptional;
    /** @var string */
    public $handler;
    /** @var string */
    public $name;
    /** @var array */
    public $middleware;

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
}
