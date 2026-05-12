<?php

namespace Platform\Form\Renderer;

use Platform\Form\Element\Upload;

class UploadRenderer extends Renderer
{
    /** @var Upload */
    private $upload;

    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    public function render(): string
    {
        return ''; // @TODO
    }
}
