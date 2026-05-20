<?php

namespace Platform\Form\Renderer;

class ButtonRenderer extends ElementRenderer
{
    public function render(): string
    {
        $attribute = self::buildAttributes(array_merge([
            'class' => 'button',
            'href' => $this->getOption('href'),
        ], $this->getOption('attributes')));

        $label = $this->resolveLabel() ?: $this->element->getName();

        return "<a {$attribute}>{$label}</a>";
    }
}
