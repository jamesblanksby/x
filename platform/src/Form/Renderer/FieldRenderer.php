<?php

namespace Platform\Form\Renderer;

abstract class FieldRenderer extends ElementRenderer
{
    protected function open(): string
    {
        $attribute = self::buildAttributes([
            'class' => 'field',
        ]);

        return "<x-field {$attribute}>";
    }

    public function label(): string
    {
        $label = $this->resolveLabel();

        if ($label === false) {
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
        $info = $this->element->getOption('info');

        if (!$info) {
            return '';
        }

        $attribute = self::buildAttributes([
            'class' => 'label',
        ]);

        return "<div {$attribute}>{$info}</div>";
    }

    public function render(): string
    {
        $html = '';

        $html .= $this->open();
        $html .= $this->label();
        $html .= $this->content();
        $html .= $this->close();

        return $html;
    }

    public function content(): string
    {
        $html = '';

        $attribute = self::buildAttributes([
            'class' => 'content',
        ]);

        $html .= "<div {$attribute}>";
        $html .= $this->widget();
        $html .= '</div>';

        return $html;
    }

    abstract public function widget(): string;

    public function close(): string
    {
        return '</x-field>';
    }

    private function resolveFor(): string
    {
        return $this->element->getOption('id') ?? $this->element->getName();
    }
}
