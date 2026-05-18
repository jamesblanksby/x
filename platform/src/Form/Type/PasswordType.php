<?php

namespace Platform\Form\Type;

class PasswordType extends InputType
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'type' => 'password',
        ]);
    }
}
