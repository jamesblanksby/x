<?php

namespace Platform\Form;

use Framework\Container\Container;
use Platform\Form\Type\TypeInterface;

class FormRegistry
{
    /** @var Container */
    private $container;
    /** @var array */
    private $types = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function resolve(string $typeClass): TypeInterface
    {
        $type = $this->types[$typeClass] ?? null;

        if ($type !== null) {
            return $type;
        }

        if (!$this->container->has($typeClass)) {
            throw new \InvalidArgumentException("Form type `{$typeClass}` could not be resolved.");
        }

        $type = $this->container->get($typeClass);

        if (!$type instanceof TypeInterface) {
            throw new \InvalidArgumentException("Form type `{$typeClass}` must implement TypeInterface.");
        }

        $this->types[$typeClass] = $type;

        return $type;
    }
}
