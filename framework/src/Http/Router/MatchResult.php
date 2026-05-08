<?php

namespace Framework\Http\Router;

class MatchResult
{
    /** @var ?Route */
    public $route = null;
    /** @var array */
    public $params = [];
    /** @var array */
    public $allowed = [];

    public function __construct(
        ?Route $route = null,
        array $params = [],
        array $allowed = []
    ) {
        $this->route = $route;
        $this->params = $params;
        $this->allowed = $allowed;
    }

    public static function found(Route $route, array $params): self
    {
        return new self($route, $params);
    }

    public static function methodNotAllowed(array $allowed): self
    {
        return new self(null, [], $allowed);
    }

    public static function notFound(): self
    {
        return new self();
    }
}
