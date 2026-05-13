<?php

namespace Platform\Form\Element;

abstract class Element implements ElementInterface
{
    /** @var array */
    private $attributes = [];

    public function __construct(string $name)
    {
        $this->name($name);
    }

    /** @return static */
    public static function make(string $name)
    {
        return new static($name);
    }

    /** @return static */
    public function id(?string $id)
    {
        $this->set('id', $id);
        return $this;
    }

    /** @return static */
    public function name(?string $name)
    {
        $this->set('name', $name);
        return $this;
    }

    /** @return static */
    public function value(?string $value)
    {
        $this->set('value', $value);
        return $this;
    }

    /** @return static */
    public function required(bool $required = true)
    {
        $this->set('required', $required);
        return $this;
    }

    /** @return static */
    public function disabled(bool $disabled = true)
    {
        $this->set('disabled', $disabled);
        return $this;
    }

    /** @return static */
    public function readonly(bool $readonly = true)
    {
        $this->set('readonly', $readonly);
        return $this;
    }

    /** @return static */
    public function autofocus(bool $autofocus = true)
    {
        $this->set('autofocus', $autofocus);
        return $this;
    }

    /** @return static */
    public function tabindex(?int $tabindex)
    {
        $this->set('tabindex', $tabindex);
        return $this;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function set(string $key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function attribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
