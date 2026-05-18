<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\SelectRenderer;

class SelectType extends Type
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'placeholder' => null,
            'choices' => [],
        ]);
    }

    public function getRendererClass(): string
    {
        return SelectRenderer::class;
    }
}
