<?php

namespace Platform\Form\Type;

class EmailType extends InputType
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'type' => 'email',
        ]);
    }
}
