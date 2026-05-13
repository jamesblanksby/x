<?php

namespace Platform\Form;

interface FormTypeInterface
{
    public function buildForm(FormBuilder $builder): void;
}
