<?php

namespace Platform\Form;

class FormBuilder
{
    /** @var FormRegistry */
    private $registry;
    /** @var array */
    private $children = [];

    public function __construct(FormRegistry $registry)
    {
        $this->registry = $registry;
    }

    /** @return static */
    public function add(string $name, string $typeClass, array $options = [], ?callable $callback = null)
    {
        $type = $this->registry->resolve($typeClass);
        $options = array_merge($type->setDefaults(), $options);

        $builder = new static($this->registry);

        if ($callback !== null) {
            $callback($builder);
        } else {
            $type->build($builder);
        }

        $this->children[$name] = new FormElement(
            $name,
            $type,
            $options,
            $builder->getChildren()
        );

        return $this;
    }

    public function getChildren(): array
    {
        return $this->children;
    }
}
