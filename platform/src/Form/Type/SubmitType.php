<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\SubmitRenderer;

class SubmitType extends Type
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'label' => null,
            'value' => null,
        ]);
    }

    public function getRendererClass(): string
    {
        return SubmitRenderer::class;
    }
}
