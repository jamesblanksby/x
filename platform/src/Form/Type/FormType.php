<?php

namespace Platform\Form\Type;

use Platform\Form\Renderer\FormRenderer;

class FormType extends ContainerType
{
    public function setDefaults(): array
    {
        return [
            'action' => null,
            'method' => 'post',
        ];
    }

    public function getRendererClass(): string
    {
        return FormRenderer::class;
    }
}
