<?php

namespace Platform\Form\Renderer;

use Platform\Utility\Html;

abstract class Renderer implements RendererInterface
{
    protected static function buildAttributes(array $attributes): string
    {
        return Html::attribute($attributes);
    }
}
