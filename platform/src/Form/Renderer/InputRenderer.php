<?php

namespace Platform\Form\Renderer;

class InputRenderer extends FieldRenderer
{
    public function widget(): string
    {
        $html = '';

        $attribute = self::buildAttributes([
            'class' => 'input',
        ]);

        $html .= "<div {$attribute}>";
        $html .= $this->element();
        $html .= '</div>';

        return $html;
    }

    public function element(): string
    {
        $attribute = self::buildAttributes(array_merge([
            'type' => $this->element->getOption('type'),
            'id' => $this->resolveId(),
            'name' => $this->element->getName(),
            'value' => $this->element->getOption('value'),
            'required' => $this->element->getOption('required'),
        ], $this->element->getOption('attributes')));

        return "<input {$attribute}>";
    }

    private function resolveId(): string
    {
        return $this->element->getOption('id') ?? $this->element->getName();
    }
}
