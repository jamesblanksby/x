<?php

namespace Platform\Module\Admin\Form\Auth;

use Platform\Form\Element\Input;
use Platform\Form\FormBuilder;
use Platform\Form\FormType;

class LoginForm extends FormType
{
    public function buildForm(FormBuilder $builder): void
    {
        $builder
            ->add(
                Input::make('email')
                    ->required(),
                'Email'
            )
            ->add(
                Input::make('password')
                    ->required(),
                'Password'
            )
        ;
    }
}
