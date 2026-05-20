<?php

namespace Platform\Form\Renderer;

use Platform\Form\FieldElement;

abstract class FieldRenderer extends ElementRenderer
{
    /** @var FieldElement */
    protected $element;

    public function __construct(FieldElement $element)
    {
        parent::__construct($element);
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
        return $this->renderLabel('label', $this->resolveId());
    }

    public function info(): string
    {
        $info = $this->getOption('info');

        if (!$info) {
            return '';
        }

        $attribute = self::buildAttributes([
            'class' => 'info',
        ]);

        return "<div {$attribute}>{$info}</div>";
    }

    public function render(): string
    {
        $html = '';

        $html .= $this->open();
        $html .= $this->label();
        $html .= $this->content();
        $html .= $this->errors();
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

    public function errors(): string
    {
        if (!$this->element->hasErrors()) {
            return '';
        }

        $html = '';

        $attribute = self::buildAttributes([
            'class' => 'errors',
        ]);

        $html .= "<div {$attribute}>";

        foreach ($this->element->getErrors() as $message) {
            $html .= $this->error($message);
        }

        $html .= '</div>';

        return $html;
    }

    public function close(): string
    {
        return '</x-field>';
    }

    protected function resolveId(): string
    {
        return $this->getOption('id') ?? $this->element->getName();
    }

    private function error(string $message): string
    {
        $attribute = self::buildAttributes([
            'class' => 'item',
        ]);

        return "<div {$attribute}>{$message}</div>";
    }
}
