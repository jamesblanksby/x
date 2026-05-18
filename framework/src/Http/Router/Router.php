<?php

namespace Framework\Http\Router;

class Router
{
    /** @var RouteCollection */
    private $collection;
    /** @var RouteMatcher */
    private $matcher;
    /** @var RouteCompiler */
    private $compiler;
    /** @var UrlGenerator */
    private $generator;

    public function __construct(
        RouteCollection $collection,
        RouteMatcher $matcher,
        RouteCompiler $compiler,
        UrlGenerator $generator
    ) {
        $this->collection = $collection;
        $this->matcher = $matcher;
        $this->compiler = $compiler;
        $this->generator = $generator;
    }

    public function add(string $method, string $path, string $handler, string $name = '', array $middleware = []): void
    {
        $route = $this->compiler->compile($path, $method, $handler, $name, $middleware);
        $this->collection->add($route);
    }

    public function match(string $method, string $path): RouteMatch
    {
        return $this->matcher->match($method, $path, $this->collection);
    }

    public function url(string $name, array $params = [], bool $absolute = true): string
    {
        return $this->generator->generate($name, $params, $absolute);
    }
}
