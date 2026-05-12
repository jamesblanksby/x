<?php

namespace Platform\Form\Element;

use Platform\Form\Renderer\InputRenderer;

class Input extends Element
{
    /** @var string */
    private $type;

    public function __construct(string $name)
    {
        $this->type('text');

        parent::__construct($name);
    }

    /** @return static */
    public function type(string $type)
    {
        $this->type = $type;
        $this->set('type', $type);

        return $this;
    }

    /** @return static */
    public function placeholder(?string $placeholder)
    {
        $this->set('placeholder', $placeholder);
        return $this;
    }

    /** @return static */
    public function pattern(?string $pattern)
    {
        $this->set('pattern', $pattern);
        return $this;
    }

    /** @return static */
    public function minlength(?int $minlength)
    {
        $this->set('minlength', $minlength);
        return $this;
    }

    /** @return static */
    public function maxlength(?int $maxlength)
    {
        $this->set('maxlength', $maxlength);
        return $this;
    }

    /** @return static */
    public function min(?float $min)
    {
        $this->set('min', $min);
        return $this;
    }

    /** @return static */
    public function max(?float $max)
    {
        $this->set('max', $max);
        return $this;
    }

    /** @return static */
    public function step(?float $step)
    {
        $this->set('step', $step);
        return $this;
    }

    /** @return static */
    public function accept(?string $accept)
    {
        $this->set('accept', $accept);
        return $this;
    }

    /** @return static */
    public function multiple(bool $multiple = true)
    {
        $this->set('multiple', $multiple);
        return $this;
    }

    /** @return static */
    public function autocomplete(bool $autocomplete = true)
    {
        $this->set('autocomplete', $autocomplete);
        return $this;
    }

    /** @return static */
    public function spellcheck(bool $spellcheck = true)
    {
        $this->set('spellcheck', $spellcheck);
        return $this;
    }

    public function render(): string
    {
        return (new InputRenderer($this))->render();
    }

    public function getType(): string
    {
        return $this->type;
    }
}
