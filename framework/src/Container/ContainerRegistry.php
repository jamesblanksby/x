<?php

namespace Framework\Container;

class ContainerRegistry
{
    /** @var array */
    private $definitions = [];
    /** @var array */
    private $instances = [];

    public function hasDefinition(string $id): bool
    {
        return isset($this->definitions[$id]);
    }

    /** @param mixed $value */
    public function setDefinition(string $id, $value): void
    {
        $this->definitions[$id] = $value;
        $this->forgetInstance($id);
    }

    /** @return mixed */
    public function getDefinition(string $id)
    {
        if (!$this->hasDefinition($id)) {
            throw new \RuntimeException("No definition found for `{$id}`.");
        }

        return $this->definitions[$id];
    }

    public function hasInstance(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    /** @param mixed $instance */
    public function setInstance(string $id, $instance): void
    {
        $this->instances[$id] = $instance;
    }

    /** @return mixed */
    public function getInstance(string $id)
    {
        return $this->instances[$id] ?? null;
    }

    public function forgetInstance(string $id): void
    {
        unset($this->instances[$id]);
    }
}
