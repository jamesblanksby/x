<?php

namespace Platform\Form\Renderer;

use Platform\Form\Element\Choice;

class ChoiceRenderer extends Renderer
{
    /** @var Choice */
    private $choice;

    public function __construct(Choice $choice)
    {
        $this->choice = $choice;
    }

    public function render(): string
    {
        return ''; // @TODO
    }
}
