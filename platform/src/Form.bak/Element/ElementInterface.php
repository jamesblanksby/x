<?php

namespace Platform\Form\Element;

interface ElementInterface
{
    /**
     * @param mixed $default
     * @return mixed
     */
    public function attribute(string $key, $default = null);

    public function render(): string;
}
