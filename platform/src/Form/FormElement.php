<?php

namespace Platform\Form;

use Platform\Form\Type\TypeInterface;

class FormElement
{
    /** @var string */
    private $name;
    /** @var TypeInterface */
    private $type;
    /** @var array */
    private $options = [];
    /** @var array */
    private $children = [];

    public function __construct(
        string $name,
        TypeInterface $type,
        array $options = [],
        array $children = []
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
        $this->children = $children;
    }

    public function render(): string
    {
        $rendererClass = $this->type->getRendererClass();

        return (new $rendererClass($this))->render();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): TypeInterface
    {
        return $this->type;
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    /** @param mixed $value */
    public function setValue($value): void
    {
        $this->options['value'] = $value;
    }

    /** @return mixed */
    public function getValue()
    {
        return $this->options['value'] ?? null;
    }

    public function isValid(Form $form): bool
    {
        $validatorClass = $this->type->getValidatorClass();

        if ($validatorClass !== null) {
            $valid = (new $validatorClass($form, $this))->validate();

            if (!$valid) {
                return false;
            }
        }

        foreach ($this->children as $child) {
            if (!$child->isValid($form)) {
                return false;
            }
        }

        return true;
    }
}
