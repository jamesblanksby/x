<?php

namespace Platform\Form\Renderer;

abstract class GroupRenderer extends ElementRenderer
{
    public function render(): string
    {
        $html  = $this->open();
        $html .= $this->label();
        $html .= $this->content();
        $html .= $this->close();

        return $html;
    }

    public function open(): string
    {
        $attribute = self::buildAttributes(array_merge([
            'class' => $this->groupClass(),
        ], $this->getOption('attributes')));

        return "<div {$attribute}>";
    }

    public function label(): string
    {
        return $this->renderLabel('div');
    }

    public function content(): string
    {
        $html = '';

        $attribute = self::buildAttributes([
            'class' => 'content',
        ]);

        $html .= "<div {$attribute}>";

        foreach ($this->element->getChildren() as $child) {
            $html .= $child->render();
        }

        $html .= '</div>';

        return $html;
    }

    public function close(): string
    {
        return '</div>';
    }

    abstract protected function groupClass(): string;
}
