<?php

namespace Platform\Form\Element;

use Platform\Form\Renderer\ChoiceRenderer;

class Choice extends Element
{
    /** @var string */
    private $type;
    /** @var array */
    private $options = [];
    /** @var array */
    private $values = [];

    public function __construct(string $name)
    {
        $this->type('checkbox');

        parent::__construct($name);
    }

    /** @return static */
    public function type(string $type)
    {
        if (!in_array($type, ['checkbox', 'radio'])) {
            throw new \InvalidArgumentException(
                "Choice type must be `checkbox` or `radio`, `{$type}` given."
            );
        }

        $this->type = $type;
        $this->set('type', $type);

        return $this;
    }

    /** @return static */
    public function options(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /** @return static */
    public function values(array $values)
    {
        $this->values = $values;
        return $this;
    }

    public function render(): string
    {
        return (new ChoiceRenderer($this))->render();
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getValues(): array
    {
        return $this->values;
    }
}
