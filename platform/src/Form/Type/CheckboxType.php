<?php

namespace Platform\Form\Type;

class CheckboxType extends ChoiceType
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'type' => 'checkbox',
        ]);
    }
}
