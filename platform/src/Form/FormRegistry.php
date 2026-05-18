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

        // @TODO validate type ?

        if (!$this->container->has($typeClass)) {
            throw new \InvalidArgumentException("Form type `{$typeClass}` could not be resolved.");
        }

        return $this->container->get($typeClass);
    }
}
