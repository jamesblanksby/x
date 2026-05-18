<?php

namespace Platform\Form\Renderer;

class FormsetRenderer extends GroupRenderer
{
    protected function groupClass(): string
    {
        return 'formset';
    }
}
