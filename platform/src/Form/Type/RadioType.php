<?php

namespace Platform\Form\Type;

class RadioType extends ChoiceType
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'type' => 'radio',
        ]);
    }
}
