<?php

namespace Platform\Form\Validator;

class FieldValidator extends Validator
{
    public function validate(): bool
    {
        $value = $this->form->getValue($this->element->getName());

        if ($this->element->getOption('required') && empty($value)) {
            return false;
        }

        return true;
    }
}
