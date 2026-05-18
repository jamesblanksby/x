<?php

namespace Platform\Form\Validator;

use Platform\Form\Form;
use Platform\Form\FormElement;

abstract class Validator implements ValidatorInterface
{
    /** @var Form */
    protected $form;
    /** @var FormElement */
    protected $element;

    public function __construct(Form $form, FormElement $element)
    {
        $this->form = $form;
        $this->element = $element;
    }
}
