<?php

namespace Platform\Form\Renderer;

use Platform\Form\Element\Input;

class InputRenderer extends Renderer
{
    /** @var Input */
    private $input;

    public function __construct(Input $input)
    {
        $this->input = $input;
    }

    public function render(): string
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
        $attribute = self::buildAttributes($this->input->getAttributes());

        return "<input {$attribute}>";
    }
}
