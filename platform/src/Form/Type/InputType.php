<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\InputRenderer;

abstract class InputType extends FieldType
{
    public function getRendererClass(): string
    {
        return InputRenderer::class;
    }
}
