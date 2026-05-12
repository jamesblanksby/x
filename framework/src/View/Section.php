<?php

namespace Framework\View;

class Section
{
    /** @var string */
    private $name;
    /** @var bool  */
    private $extend;
    /** @var string */
    private $content;

    public function __construct(string $name, bool $extend, string $content = '')
    {
        $this->name = $name;
        $this->extend = $extend;
        $this->content = $content;
    }

    public function write(string $content): void
    {
        if ($this->extend) {
            $this->content = $this->content . $content;
        } else {
            $this->content = $content;
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function shouldExtend(): bool
    {
        return $this->extend;
    }
}
