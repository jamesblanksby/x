<?php

namespace Platform\Form\Type;

use Platform\Form\FormBuilder;

abstract class Type implements TypeInterface
{
    public function build(FormBuilder $builder): void
    {
        // no-op
    }

    public function setDefaults(): array
    {
        return [];
    }

    public function getValidatorClass(): ?string
    {
        return null;
    }
}
