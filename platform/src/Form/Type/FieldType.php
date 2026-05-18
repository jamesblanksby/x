<?php

namespace Platform\Form\Type;

use Platform\Form\Validator\FieldValidator;

abstract class FieldType extends Type
{
    public function setDefaults(): array
    {
        return array_merge(parent::setDefaults(), [
            'attributes' => [],
            'class' => 'field',
            'id' => null,
            'info' => null,
            'label' => null,
            'required' => true,
        ]);
    }

    public function getValidatorClass(): ?string
    {
        return FieldValidator::class;
    }
}
