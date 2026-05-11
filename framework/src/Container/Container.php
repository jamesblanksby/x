<?php

namespace Framework\Container;

class Container
{
    /** @var ContainerRegistry */
    private $registry;
    /** @var DependencyResolver */
    private $resolver;
    /** @var array */
    private $stack = [];

    public function __construct()
    {
        $this->registry = new ContainerRegistry();
        $this->resolver = new DependencyResolver(new DependencyBuilder(), $this->registry);
    }

    public function has(string $id): bool
    {
        return $this->registry->hasDefinition($id) || class_exists($id);
    }

    /** @param mixed $value */
    public function set(string $id, $value): void
    {
        $this->registry->setDefinition($id, $value);
    }

    /** @return mixed */
    public function get(string $id)
    {
        if ($this->registry->hasInstance($id)) {
            return $this->registry->getInstance($id);
        }

        if (!$this->has($id)) {
            throw new \RuntimeException("Cannot resolve `{$id}`.");
        }

        if (isset($this->stack[$id])) {
            throw new \RuntimeException("Circular dependency detected while resolving `{$id}`.");
        }

        $this->stack[$id] = true;

        try {
            $instance = $this->make($id);
            $this->registry->setInstance($id, $instance);
        } finally {
            unset($this->stack[$id]);
        }

        return $instance;
    }

    /** @return mixed */
    public function make(string $id, array $params = [])
    {
        return $this->resolver->resolve($id, $params, [$this, 'get']);
    }
}
