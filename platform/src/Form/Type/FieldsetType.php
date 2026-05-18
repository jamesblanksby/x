<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\FieldsetRenderer;

abstract class FieldsetType extends Type
{
    public function getRendererClass(): string
    {
        return FieldsetRenderer::class;
    }
}
