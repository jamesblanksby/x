<?php

namespace Platform\Form\Validator;

use Framework\Utility\Value;
use Platform\Form\FieldElement;
use Platform\Form\Form;

class FieldValidator extends Validator
{
    /** @var FieldElement */
    protected $element;

    public function __construct(Form $form, FieldElement $element)
    {
        parent::__construct($form, $element);
    }

    public function validate(): void
    {
        $required = $this->element->getOption('required');
        $value = $this->element->getValue();

        if ($required && Value::blank($value)) {
            $this->element->addError('This field is required.');
        }
    }
}
