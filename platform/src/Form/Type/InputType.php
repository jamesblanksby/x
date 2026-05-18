<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\InputRenderer;

class InputType extends FieldType
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'value' => null,
        ]);
    }

    public function getRendererClass(): string
    {
        return InputRenderer::class;
    }
}
