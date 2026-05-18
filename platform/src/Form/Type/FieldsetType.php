<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\FieldsetRenderer;

abstract class FieldsetType extends ContainerType
{
    public function getRendererClass(): string
    {
        return FieldsetRenderer::class;
    }
}
