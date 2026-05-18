<?php

namespace Platform\Form\Type;

use Platform\Form\FormBuilder;

interface TypeInterface
{
    public function build(FormBuilder $builder): void;

    public function setDefaults(): array;

    public function getRendererClass(): string;

    public function getValidatorClass(): ?string;
}
