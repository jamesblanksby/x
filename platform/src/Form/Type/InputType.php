<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\InputRenderer;

class InputType extends FieldType
{
    public function getRendererClass(): string
    {
        return InputRenderer::class;
    }
}
