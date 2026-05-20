<?php

namespace Platform\Form\Renderer;

use Framework\Utility\Html;

abstract class Renderer implements RendererInterface
{
    protected static function buildAttributes(array $attributes): string
    {
        return Html::attribute($attributes);
    }
}
