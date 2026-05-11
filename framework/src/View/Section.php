<?php

namespace Framework\View;

use Framework\Support\ValueObject;

class Section extends ValueObject
{
    /** @var string */
    public $name;
    /** @var bool  */
    public $extend;
    /** @var string */
    public $content;

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
}
