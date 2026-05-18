<?php

namespace Framework\Http\Router;

class RouteMatch
{
    /** @var ?Route */
    private $route = null;
    /** @var array */
    private $params = [];
    /** @var array */
    private $allowed = [];

    private function __construct(
        ?Route $route = null,
        array $params = [],
        array $allowed = []
    ) {
        $this->route = $route;
        $this->params = $params;
        $this->allowed = $allowed;
    }

    /** @return static */
    public static function found(Route $route, array $params)
    {
        return new static($route, $params);
    }

    /** @return static */
    public static function notAllowed(array $allowed)
    {
        return new static(null, [], $allowed);
    }

    /** @return static */
    public static function notFound()
    {
        return new static();
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
