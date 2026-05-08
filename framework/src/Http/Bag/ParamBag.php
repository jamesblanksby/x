<?php

namespace Framework\Http\Bag;

class ParamBag
{
    /** @var array */
    private $params = [];

    public function __construct(array $params = [])
    {
        $this->add($params);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->params);
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function set(string $key, $value)
    {
        $this->params[$key] = $value;
        return $this;
    }

    /** @return static */
    public function add(array $params)
    {
        foreach ($params as $key => $value) {
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
        return $this->params[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->params;
    }

    /** @return static */
    public function remove(string $key)
    {
        unset($this->params[$key]);
        return $this;
    }

    /** @return static */
    public function replace(array $params)
    {
        $this->params = [];
        $this->add($params);

        return $this;
    }
}
