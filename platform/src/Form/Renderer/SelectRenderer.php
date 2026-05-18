<?php

namespace Platform\Form\Renderer;

class SelectRenderer extends FieldRenderer
{
    public function render(): string
    {
        $html = '';

        $html .= $this->open();
        $html .= $this->label();

        d('SELECT');

        d('/SELECT');

        $html .= $this->close();

        return $html;
    }
}
