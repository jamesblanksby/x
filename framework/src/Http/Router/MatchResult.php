<?php

namespace Framework\Http\Router;

class MatchResult
{
    /** @var ?Route */
    private $route = null;
    /** @var array */
    private $params = [];
    /** @var array */
    private $allowed = [];

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

    public function getRoute(): ?Route
    {
        return $this->route;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getAllowed(): array
    {
        return $this->allowed;
    }

    public function isMatched(): bool
    {
        return !!$this->route;
    }

    public function isAllowed(): bool
    {
        return !$this->allowed;
    }
}
