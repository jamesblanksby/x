<?php

namespace Platform\Form\Type;

class UrlType extends InputType
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'type' => 'url',
        ]);
    }
}
