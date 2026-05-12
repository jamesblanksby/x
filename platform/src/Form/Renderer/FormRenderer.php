<?php

namespace Platform\Form\Renderer;

use Platform\Form\Form;

class FormRenderer extends Renderer
{
    /** @var Form */
    private $form;

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function render(): string
    {
        $html = '';

        $html .= $this->open();
        $html .= $this->content();
        $html .= $this->close();

        return $html;
    }

    public function open(): string
    {
        // @TODO
        $action = '';
        $method = '';

        $attribute = self::buildAttributes([
            'class' => 'form',
            'action' => $action,
            'method' => $method,
        ]);

        return "<x-form {$attribute}>";
    }

    public function content(): string
    {
        $attribute = self::buildAttributes([
            'class' => 'content',
        ]);

        $html = '';

        $html .= "<div {$attribute}>";
        $html .= $this->fields();
        $html .= '</div>';

        return $html;
    }

    public function fields(): string
    {
        $html = '';

        foreach ($this->form->fields as $name => $field) {
            $error = $this->form->getError($name);
            // @TODO error
            $html .= $field->render();
        }

        return $html;
    }

    public function close(): string
    {
        return '</x-form>';
    }
}
