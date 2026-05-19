<?php

namespace Platform\Module\Admin\Form\Type;

use Framework\Http\Router\Router;
use Platform\Form\FormBuilder;
use Platform\Form\Type\ButtonsetType;
use Platform\Form\Type\ButtonType;
use Platform\Form\Type\EmailType;
use Platform\Form\Type\FormsetType;
use Platform\Form\Type\FormType;
use Platform\Form\Type\SubmitType;

class PasswordRecoverType extends FormType
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
            ->add('recover', FormsetType::class, [], function (FormBuilder $builder) {
                $builder
                    ->add('email', EmailType::class)
                ;
            })
            ->add('submit', ButtonsetType::class, [], function (FormBuilder $builder) {
                $builder
                    ->add('recover', SubmitType::class)
                    ->add('back', ButtonType::class, [
                        'href' => $this->router->url('admin.page.index'),
                    ])
                ;
            })
        ;
    }
}
