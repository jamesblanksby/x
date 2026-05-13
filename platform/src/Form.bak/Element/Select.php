<?php

namespace Platform\Form\Element;

use Platform\Form\Renderer\ChoiceRenderer;

class Choice extends Element
{
    /** @var ?string */
    private $placeholder = null;
    /** @var array */
    private $options = [];

    /** @return static */
    public function placeholder(?string $placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /** @return static */
    public function options(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /** @return static */
    public function multiple(bool $multiple = true)
    {
        $this->set('multiple', $multiple);
    }

    /** @return static */
    public function size(?int $size)
    {
        $this->set('size', $size);
    }

    public function render(): string
    {
        return (new ChoiceRenderer($this))->render();
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
