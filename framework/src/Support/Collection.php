<?php

namespace Framework\Support;

class Collection
{
    /** @var array */
    private $items = [];

    public function __construct(array $items = [])
    {
        $this->add($items);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function set(string $key, $value)
    {
        $this->items[$key] = $value;
        return $this;
    }

    /** @return static */
    public function add(array $items)
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->items[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->items;
    }

    /** @return static */
    public function remove(string $key)
    {
        unset($this->items[$key]);
        return $this;
    }

    /** @return static */
    public function replace(array $items)
    {
        $this->items = [];
        $this->add($items);

        return $this;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return !$this->items;
    }

    public function keys(): array
    {
        return array_keys($this->items);
    }

    public function values(): array
    {
        return array_values($this->items);
    }

    /** @return static */
    public function filter(callable $callback)
    {
        $clone = clone $this;
        $clone->items = array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH);

        return $clone;
    }

    /** @return static */
    public function map(callable $callback)
    {
        $clone = clone $this;
        $clone->items = array_map($callback, $this->items);

        return $clone;
    }

    /** @return static */
    public function merge(self $collection)
    {
        $clone = clone $this;
        $clone->items = array_merge($this->items, $collection->all());

        return $clone;
    }
}
