<?php

namespace Platform\View\Extension;

use Framework\View\Extension\ExtensionInterface;
use Framework\View\View;
use Platform\Form\Form;

class FormExtension implements ExtensionInterface
{
    public function register(View $view): void
    {
        $view->addFunction('form', [$this, 'form']);
    }

    public function form(Form $form): string
    {
        return $form->render();
    }
}
