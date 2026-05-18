<?php

namespace Platform\Module\Admin\Form\Type;

use Platform\Form\FormBuilder;
use Platform\Form\Type\EmailType;

use Platform\Form\Type\FormsetType;
use Platform\Form\Type\FormType;
use Platform\Form\Type\PasswordType;

class LoginType extends FormType
{
    public function build(FormBuilder $builder): void
    {
        $builder
            ->add('login', FormsetType::class, [], function (FormBuilder $builder) {
                $builder
                    ->add('email', EmailType::class)
                    ->add('password', PasswordType::class)
                ;
            })
        ;
    }
}
