<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\FormsetRenderer;

class FormsetType extends Type
{
    public function getRendererClass(): string
    {
        return FormsetRenderer::class;
    }
}
