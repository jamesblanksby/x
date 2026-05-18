<?php

namespace Platform\Form\Renderer;

class FormsetRenderer extends ContainerRenderer
{
    public function open(): string
    {
        $attribute = self::buildAttributes(array_merge([
            'class' => 'formset',
        ], $this->element->getOption('attributes', [])));

        return "<div {$attribute}>";
    }
}
