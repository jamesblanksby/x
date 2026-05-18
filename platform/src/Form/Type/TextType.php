<?php

namespace Platform\Form\Type;

class TextType extends InputType
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'type' => 'text',
        ]);
    }
}
