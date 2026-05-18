<?php

namespace Platform\Form\Renderer;

class FieldsetRenderer extends ContainerRenderer
{
    public function open(): string
    {
        $attribute = self::buildAttributes(array_merge([
            'class' => 'fieldset',
        ], $this->element->getOption('attributes', [])));

        return "<div {$attribute}>";
    }
}
