<?php

namespace Platform\Form\Type;

class NumberType extends InputType
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'type' => 'number',
            'min' => null,
            'max' => null,
            'step' => 1,
        ]);
    }
}
