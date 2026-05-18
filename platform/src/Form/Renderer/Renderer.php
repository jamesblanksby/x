<?php

namespace Platform\Form\Renderer;

use Platform\Utility\Html;

abstract class Renderer implements RendererInterface
{
    protected function humanizeName(string $name): string
    {
        $name = str_replace('_', ' ', $name);
        $name = preg_replace('/(?<!\s)([A-Z])/', ' $1', $name);
        $name = trim($name);

        return mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
    }

    protected static function buildAttributes(array $attributes): string
    {
        return Html::attribute($attributes);
    }
}
