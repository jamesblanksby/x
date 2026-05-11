<?php

namespace Framework\Support;

abstract class ValueObject
{
    /** @return mixed */
    public function __get(string $name)
    {
        $this->assertPropertyExists($name);

        return $this->{$name};
    }

    /** @param mixed $value */
    public function __set(string $name, $value): void
    {
        $this->assertPropertyExists($name);

        throw new \LogicException(
            sprintf('Cannot modify readonly property %s::$%s.', static::class, $name)
        );
    }

    private function assertPropertyExists(string $name): void
    {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException(
                sprintf('Property `%s` does not exist on %s.', $name, static::class)
            );
        }
    }
}
