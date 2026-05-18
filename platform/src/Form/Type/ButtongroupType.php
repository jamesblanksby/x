<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\ButtongroupRenderer;

class ButtongroupType extends GroupType
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'label' => false,
        ]);
    }

    public function getRendererClass(): string
    {
        return ButtongroupRenderer::class;
    }
}
