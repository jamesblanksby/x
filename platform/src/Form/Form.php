<?php

namespace Platform\Form;

use Framework\Http\Request\Request;
use Framework\Support\ValueObject;
use Platform\Form\Renderer\FormRenderer;

class Form extends ValueObject
{
    /** @var array */
    public $fields;
    /** @var array */
    public $options = [];

    /** @var array */
    private $data = [];
    /** @var array */
    private $errors = [];

    /** @var bool */
    private $submitted = false;

    public function __construct(array $fields, array $options = [])
    {
        $this->fields = $fields;
        $this->options = $options;
    }

    /** @return static */
    public function handleRequest(Request $request)
    {
        $this->data = $request->input->all();
        $this->submitted = true;

        return $this;
    }

    public function isSubmitted(): bool
    {
        return $this->submitted;
    }

    public function isValid(): bool
    {
        $this->errors = [];

        foreach ($this->fields as $name => $field) {
            $element = $field->element;

            if (!$element) {
                continue;
            }

            $required = $element->attribute('required');
            $value = $this->getValue($name);

            if ($required && ($value === null || $value === '')) {
                $label = $field->label ?? $name;
                $this->errors[$name] = "{$label} is required.";
            }
        }

        return !$this->errors;
    }

    public function getField(string $name): ?Field
    {
        return $this->fields[$name] ?? null;
    }

    /** @return mixed */
    public function getValue(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function getError(string $name): ?string
    {
        return $this->errors[$name] ?? null;
    }

    public function render(): string
    {
        return (new FormRenderer($this))->render();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
