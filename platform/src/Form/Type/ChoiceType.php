<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\ChoiceRenderer;

abstract class ChoiceType extends FieldType
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'choices' => [],
        ]);
    }

    public function getRendererClass(): string
    {
        return ChoiceRenderer::class;
    }
}
