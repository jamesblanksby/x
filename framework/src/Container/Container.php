<?php

namespace Framework\Container;

class Container
{
    /** @var ContainerRegistry */
    private $registry;
    /** @var DependencyResolver */
    private $resolver;

    public function __construct()
    {
        $this->registry = new ContainerRegistry();
        $this->resolver = new DependencyResolver($this->registry, new DependencyReflector());
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
            throw new \RuntimeException("`{$id}` is not registered in the container.");
        }

        $instance = $this->make($id);
        $this->registry->setInstance($id, $instance);

        return $instance;
    }

    /** @return mixed */
    public function make(string $id, array $params = [])
    {
        return $this->resolver->resolve($id, $params, [$this, 'get']);
    }
}
