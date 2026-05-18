<?php

namespace Platform\Form\Renderer;

abstract class ContainerRenderer extends ElementRenderer
{
    public function render(): string
    {
        $html  = $this->open();
        $html .= $this->label();
        $html .= $this->content();
        $html .= $this->close();

        return $html;
    }

    abstract public function open(): string;

    public function label(): string
    {
        $label = $this->resolveLabel();

        if ($label === false) {
            return '';
        }

        $attribute = self::buildAttributes([
            'class' => 'label',
        ]);

        return "<div {$attribute}>{$label}</div>";
    }

    public function content(): string
    {
        $html = '';
        foreach ($this->element->getChildren() as $child) {
            $html .= $child->render();
        }

        return $html;
    }

    public function close(): string
    {
        return '</div>';
    }
}
