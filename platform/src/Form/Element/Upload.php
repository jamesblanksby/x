<?php

namespace Platform\Form\Element;

use Platform\Form\Renderer\UploadRenderer;

class Upload extends Element
{
    /** @var ?string */
    public $placeholder = null;
    /** @var ?string */
    public $value = null;
    /** @var bool */
    public $disabled = false;
    /** @var ?string */
    public $accept = null;
    /** @var ?int */
    public $limit = 1;
    /** @var ?int */
    public $maxsize = null;
    /** @var int */
    public $chunk = ((1024 * 1024) * 2);
    /** @var ?string */
    public $url = null;
    /** @var bool */
    public $removable = false;

    /** @return static */
    public function placeholder(?string $placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /** @return static */
    public function value(?string $value)
    {
        $this->value = $value;
        return $this;
    }

    public function disabled(bool $disabled = true)
    {
        $this->disabled = $disabled;
        return $this;
    }

    /** @return static */
    public function accept(?string $accept)
    {
        $this->accept = $accept;
        return $this;
    }

    /** @return static */
    public function limit(?int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /** @return static */
    public function maxsize(?int $maxsize)
    {
        $this->maxsize = $maxsize;
        return $this;
    }

    /** @return static */
    public function chunk(int $chunk)
    {
        $this->chunk = $chunk;
        return $this;
    }

    /** @return static */
    public function url(?string $url)
    {
        $this->url = $url;
        return $this;
    }

    public function removable(bool $removable = true): self
    {
        $this->removable = $removable;
        return $this;
    }

    public function render(): string
    {
        return (new UploadRenderer($this))->render();
    }
}
