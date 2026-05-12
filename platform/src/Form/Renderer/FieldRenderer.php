<?php

namespace Platform\Form\Renderer;

use Platform\Form\Field;

class FieldRenderer extends Renderer
{
    /** @var Field */
    private $field;

    public function __construct(Field $field)
    {
        $this->field = $field;
    }

    public function render(): string
    {
        $html = '';

        $html .= $this->open();
        $html .= $this->label();
        $html .= $this->info();
        $html .= $this->content();
        $html .= $this->close();

        return $html;
    }

    public function open(): string
    {
        $attribute = self::buildAttributes([
            'class' => 'field',
        ]);

        return "<x-field {$attribute}>";
    }

    public function label(): string
    {
        $label = $this->field->getLabel();

        if (!$label) {
            return '';
        }

        $attribute = self::buildAttributes([
            'class' => 'label',
            'for' => $this->resolveFor(),
        ]);

        return "<label {$attribute}>{$label}</label>";
    }

    public function info(): string
    {
        $info = $this->field->getInfo();

        if (!$info) {
            return '';
        }

        $attribute = self::buildAttributes([
            'class' => 'info',
        ]);

        return "<div {$attribute}>{$info}</div>";
    }

    public function content(): string
    {
        $attribute = self::buildAttributes([
            'class' => 'content',
        ]);

        $html = '';

        $html .= "<div {$attribute}>";
        $html .= $this->before();
        $html .= $this->element();
        $html .= $this->after();
        $html .= '</div>';

        return $html;
    }

    public function before(): string
    {
        return ''; // @TODO
    }

    public function element(): string
    {
        $element = $this->field->getElement();

        if (!$element) {
            return '';
        }

        return $element->render();
    }

    public function after(): string
    {
        return ''; // @TODO
    }

    public function close(): string
    {
        return "</x-field>";
    }

    private function resolveFor(): string
    {
        $element = $this->field->getElement();

        if (!$element) {
            return '';
        }

        return $element->attribute('id') ?? $element->attribute('name') ?? '';
    }
}
