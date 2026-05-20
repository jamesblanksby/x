<?php

namespace Platform\Form\Type;

use Platform\Form\Validator\FieldValidator;

abstract class FieldType extends Type
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'info' => null,
            'label' => null,
            'id' => null,
            'value' => null,
            'required' => true,
            'readonly' => false,
            'attributes' => [],
        ]);
    }

    public function getValidatorClass(): ?string
    {
        return FieldValidator::class;
    }
}
