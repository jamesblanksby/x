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
        $view->addFunction('field', [$this, 'field']);

        // @TODO
        // form_open
        // form_close
    }

    public function form(Form $form): void
    {
        echo $form->render();
    }

    public function field(Form $form, string $name): void
    {
        $field = $form->getField($name);

        if (!$field) {
            // @TODO exception
        }

        echo $field->render();
    }
}
