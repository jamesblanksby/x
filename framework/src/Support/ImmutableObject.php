<?php

namespace Framework\Support;

abstract class ImmutableObject
{
    /** @return mixed */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        throw new \InvalidArgumentException(
            sprintf('Property "%s" does not exist on %s.', $name, static::class)
        );
    }

    /** @param mixed $value */
    public function __set(string $name, $value): void
    {
        throw new \LogicException(
            sprintf('Cannot modify readonly property %s::$%s.', static::class, $name)
        );
    }

    public function __isset(string $name): bool
    {
        return isset($this->$name);
    }
}
