<?php

namespace Platform\Form;

use Platform\Form\Type\FieldType;

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

    public function add(string $name, string $typeClass, array $options = [], ?callable $callback = null): self
    {
        $type = $this->registry->resolve($typeClass);
        $options = array_merge($type->setDefaults(), $options);

        $builder = new self($this->registry);

        if ($callback !== null) {
            $callback($builder);
        } else {
            $type->build($builder);
        }

        $elementClass = $type instanceof FieldType ? FieldElement::class : FormElement::class;

        $this->children[$name] = new $elementClass(
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
