<?php

namespace Platform\View\Extension;

use Framework\View\Extension\ExtensionInterface;
use Framework\View\View;
use Platform\Form\FieldElement;
use Platform\Form\Form;
use Platform\Form\Renderer\FieldRenderer;
use Platform\Form\Renderer\FormRenderer;

class FormExtension implements ExtensionInterface
{
    public function register(View $view): void
    {
        $view->addFunction('form', [$this, 'form']);
        $view->addFunction('form_open', [$this, 'formOpen']);
        $view->addFunction('form_close', [$this, 'formClose']);
        $view->addFunction('form_content', [$this, 'formContent']);
        $view->addFunction('field', [$this, 'field']);
        $view->addFunction('field_open', [$this, 'fieldOpen']);
        $view->addFunction('field_close', [$this, 'fieldClose']);
        $view->addFunction('field_label', [$this, 'fieldLabel']);
        $view->addFunction('field_widget', [$this, 'fieldWidget']);
        $view->addFunction('field_errors', [$this, 'fieldErrors']);
        $view->addFunction('field_info', [$this, 'fieldInfo']);
    }

    public function form(Form $form): string
    {
        return $form->render();
    }

    public function formOpen(Form $form): string
    {
        return $this->formRenderer($form)->open();
    }

    public function formClose(Form $form): string
    {
        return $this->formRenderer($form)->close();
    }

    public function formContent(Form $form): string
    {
        return $this->formRenderer($form)->content();
    }

    public function field(FieldElement $element): string
    {
        return $element->render();
    }

    public function fieldOpen(FieldElement $element): string
    {
        return $this->fieldRenderer($element)->open();
    }

    public function fieldClose(FieldElement $element): string
    {
        return $this->fieldRenderer($element)->close();
    }

    public function fieldLabel(FieldElement $element): string
    {
        return $this->fieldRenderer($element)->label();
    }

    public function fieldWidget(FieldElement $element): string
    {
        return $this->fieldRenderer($element)->widget();
    }

    public function fieldErrors(FieldElement $element): string
    {
        return $this->fieldRenderer($element)->errors();
    }

    public function fieldInfo(FieldElement $element): string
    {
        return $this->fieldRenderer($element)->info();
    }

    private function formRenderer(Form $form): FormRenderer
    {
        return new FormRenderer($form);
    }

    private function fieldRenderer(FieldElement $element): FieldRenderer
    {
        $class = $element->getType()->getRendererClass();

        return new $class($element);
    }
}
