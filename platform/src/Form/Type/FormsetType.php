<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\FormsetRenderer;

class FormsetType extends ContainerType
{
    public function getRendererClass(): string
    {
        return FormsetRenderer::class;
    }
}
