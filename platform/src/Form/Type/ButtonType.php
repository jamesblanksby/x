<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\ButtonRenderer;

class ButtonType extends Type
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'href' => null,
            'label' => null,
        ]);
    }

    public function getRendererClass(): string
    {
        return ButtonRenderer::class;
    }
}
