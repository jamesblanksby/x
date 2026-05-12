<?php

namespace Platform\Form;

use Framework\Support\ValueObject;
use Platform\Form\Element\ElementInterface;

class FormBuilder extends ValueObject
{
    /** @var array */
    public $fields = [];

    /** @var array */
    private $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /** @return static */
    public function add(ElementInterface $element, ?string $label = null, ?string $info = null, array $before = [], array $after = [])
    {
        $name = $element->attribute('name');

        $this->bindValue($name, $element);

        $field = new Field(
            $label,
            $info,
            $element
        );

        if ($before) {
            $field->before(...$before);
        }

        if ($after) {
            $field->after(...$after);
        }

        $this->fields[$name] = $field;

        return $this;
    }

    private function bindValue(string $name, ElementInterface $element): void
    {
        $value = $this->data[$name] ?? null;

        if ($value === null) {
            return;
        }

        if (!method_exists($element, 'value')) {
            return;
        }

        if ($element->attribute('value') === null) {
            $element->value($value);
        }
    }
}
