<?php

namespace Platform\Form;

use Platform\Form\Block\BlockInterface;
use Platform\Form\Element\ElementInterface;
use Platform\Form\Renderer\FieldRenderer;

class Field
{
    /** @var ?string */
    private $label;
    /** @var ?string */
    private $info;
    /** @var ?ElementInterface */
    private $element;
    /** @var array */
    private $before = [];
    /** @var array */
    private $after = [];

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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function getElement(): ?ElementInterface
    {
        return $this->element;
    }

    public function getBefore(): array
    {
        return $this->before;
    }

    public function getAfter(): array
    {
        return $this->after;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
