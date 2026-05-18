<?php

namespace Platform\Form\Renderer;

use Platform\Form\FormElement;
use Platform\Form\Type\TypeInterface;

abstract class ElementRenderer extends Renderer
{
    /** @var FormElement */
    protected $element;
    /** @var TypeInterface */
    protected $type;

    public function __construct(FormElement $element)
    {
        $this->element = $element;
        $this->type = $element->getType();
    }

    protected function resolveLabel(): string
    {
        $label = $this->element->getOption('label');

        if ($label === false) {
            return false;
        }

        if ($label !== null) {
            return $label;
        }

        $name = $this->element->getName();

        return $this->humanizeName($name);
    }
}
