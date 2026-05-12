<?php

namespace Platform\Form\Element;

use Platform\Form\Renderer\ChoiceRenderer;

class Choice extends Element
{
    /** @var ?string */
    public $placeholder = null;
    /** @var array */
    public $options = [];

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

    // multiple
    // size

    public function render(): string
    {
        return (new ChoiceRenderer($this))->render();
    }
}
