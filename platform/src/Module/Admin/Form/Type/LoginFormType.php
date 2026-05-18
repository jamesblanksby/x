<?php

namespace Platform\Module\Admin\Form\Type;

use Framework\Http\Router\Router;
use Platform\Form\FormBuilder;
use Platform\Form\Type\ButtongroupType;
use Platform\Form\Type\ButtonType;
use Platform\Form\Type\EmailType;
use Platform\Form\Type\FormsetType;
use Platform\Form\Type\FormType;
use Platform\Form\Type\PasswordType;
use Platform\Form\Type\SubmitType;

class LoginFormType extends FormType
{
    /** @var Router */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function build(FormBuilder $builder): void
    {
        $builder
            ->add('login', FormsetType::class, [
                'label' => false,
            ], function (FormBuilder $builder) {
                $builder
                    ->add('email', EmailType::class)
                    ->add('password', PasswordType::class)
                ;
            })
            ->add('submit', ButtongroupType::class, [], function (FormBuilder $builder) {
                $builder
                    ->add('login', SubmitType::class)
                    ->add('password', ButtonType::class, [
                        'href' => $this->router->url('admin.password.recover'),
                        'label' => 'Recover Password',
                    ])
                ;
            })
        ;
    }
}
