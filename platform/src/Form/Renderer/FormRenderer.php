<?php

namespace Platform\Form\Renderer;

use Platform\Form\Form;
use Platform\Form\Type\TypeInterface;

class FormRenderer extends Renderer
{
    /** @var Form */
    protected $form;
    /** @var TypeInterface */
    protected $type;

    public function __construct(Form $form)
    {
        $this->form = $form;
        $this->type = $form->getType();
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
        $attribute = self::buildAttributes(array_merge([
            'class' => 'form',
            'action' => $this->form->getOption('action'),
            'method' => $this->form->getOption('method'),
        ], $this->form->getOption('attributes')));

        return "<x-form {$attribute}>";
    }

    public function content(): string
    {
        $html = '';

        $attribute = self::buildAttributes([
            'class' => 'content',
        ]);

        $html .= "<div {$attribute}>";

        foreach ($this->form->getChildren() as $child) {
            $html .= $child->render();
        }

        $html .= '</div>';

        return $html;
    }

    public function close(): string
    {
        return '</x-form>';
    }
}
