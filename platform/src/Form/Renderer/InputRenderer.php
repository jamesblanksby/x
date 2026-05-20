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
        $html .= $this->input();
        $html .= '</div>';

        return $html;
    }

    private function input(): string
    {
        $attribute = self::buildAttributes(array_merge([
            'type' => $this->getOption('type'),
            'id' => $this->resolveId(),
            'name' => $this->element->getName(),
            'value' => $this->element->getValue(),
            'required' => $this->getOption('required'),
        ], $this->getOption('attributes')));

        return "<input {$attribute}>";
    }
}
