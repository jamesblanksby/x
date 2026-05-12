<?php

namespace Platform\Form\Renderer;

use Platform\Form\Element\Textarea;

class TextareaRenderer extends Renderer
{
    /** @var Textarea */
    private $textarea;

    public function __construct(Textarea $textarea)
    {
        $this->textarea = $textarea;
    }

    public function render(): string
    {
        $html = '';

        $attribute = self::buildAttributes([
            'class' => 'textarea',
        ]);

        $html .= "<div {$attribute}>";
        $html .= $this->element();
        $html .= '</div>';

        return $html;
    }

    public function element(): string
    {
        $textarea = $this->textarea;
        $attribute = self::buildAttributes($textarea->attributes);

        return "<textarea {$attribute}>{$textarea->value}</textarea>";
    }
}
