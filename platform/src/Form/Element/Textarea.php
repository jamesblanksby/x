<?php

namespace Platform\Form\Element;

use Platform\Form\Renderer\TextareaRenderer;

class Textarea extends Element
{
    /** @var ?string */
    public $value = null;

    public function value(?string $value)
    {
        $this->value = $value;
        return $this;
    }

    /** @return static */
    public function placeholder(?string $placeholder)
    {
        $this->set('placeholder', $placeholder);
        return $this;
    }

    /** @return static */
    public function rows(?int $rows)
    {
        $this->set('rows', $rows);
        return $this;
    }

    /** @return static */
    public function cols(?int $cols)
    {
        $this->set('cols', $cols);
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
    public function spellcheck(bool $spellcheck = true)
    {
        $this->set('spellcheck', $spellcheck);
        return $this;
    }

    public function render(): string
    {
        return (new TextareaRenderer($this))->render();
    }
}
