<?php

namespace Platform\Form;

use Framework\Support\ValueObject;
use Platform\Form\Block\BlockInterface;
use Platform\Form\Element\ElementInterface;
use Platform\Form\Renderer\FieldRenderer;

class Field extends ValueObject
{
    /** @var ?string */
    public $label;
    /** @var ?string */
    public $info;
    /** @var ?ElementInterface */
    public $element;
    /** @var array */
    public $before = [];
    /** @var array */
    public $after = [];

    public function __construct(?string $label = null, ?string $info = null, ?ElementInterface $element = null)
    {
        $this->label($label);
        $this->info($info);
        $this->element($element);
    }

    /** @return static */
    public function label(?string $label)
    {
        $this->label = $label;
        return $this;
    }

    /** @return static */
    public function info(?string $info)
    {
        $this->info = $info;
        return $this;
    }

    /** @return static */
    public function element(?ElementInterface $element)
    {
        $this->element = $element;

        // @TODO inferBlocks

        return $this;
    }

    /** @return static */
    public function before(BlockInterface ...$blocks)
    {
        $this->before = array_merge($this->before, $blocks);
        return $this;
    }

    /** @return static */
    public function after(BlockInterface ...$blocks)
    {
        $this->after = array_merge($this->after, $blocks);
        return $this;
    }

    public function render(): string
    {
        return (new FieldRenderer($this))->render();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
