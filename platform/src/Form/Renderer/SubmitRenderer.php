<?php

namespace Platform\Form\Renderer;

class SubmitRenderer extends ElementRenderer
{
    public function render(): string
    {
        $attribute = self::buildAttributes(array_merge([
            'class' => 'button',
            'type' => 'submit',
            'name' => $this->element->getName(),
            'value' => $this->element->getValue(),
        ], $this->getOption('attributes')));

        $label = $this->resolveLabel();

        return "<button {$attribute}>{$label}</button>";
    }
}
