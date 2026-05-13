<?php

namespace Platform\Form\Element;

use Platform\Form\Renderer\UploadRenderer;

class Upload extends Element
{
    /** @var ?string */
    private $placeholder = null;
    /** @var ?string */
    private $value = null;
    /** @var bool */
    private $disabled = false;
    /** @var ?string */
    private $accept = null;
    /** @var ?int */
    private $limit = 1;
    /** @var ?int */
    private $maxsize = null;
    /** @var int */
    private $chunk = ((1024 * 1024) * 2);
    /** @var ?string */
    private $url = null;
    /** @var bool */
    private $removable = false;

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

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getAccept(): ?string
    {
        return $this->accept;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getMaxsize(): ?int
    {
        return $this->maxsize;
    }

    public function getChunk(): int
    {
        return $this->chunk;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function isRemoveable(): bool
    {
        return $this->removable;
    }
}
