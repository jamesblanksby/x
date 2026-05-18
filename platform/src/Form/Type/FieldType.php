<?php

namespace Platform\Form\Type;

use Platform\Form\Validator\FieldValidator;

abstract class FieldType extends Type
{
    public function setDefaults(): array
    {
        return [
            'required' => true,
        ];
    }

    public function getValidatorClass(): ?string
    {
        return FieldValidator::class;
    }
}
