<?php

namespace Platform\Form;

use Platform\Form\Element\ElementInterface;

class FormBuilder
{
    /** @var array */
    private $fields = [];
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

    public function getFields(): array
    {
        return $this->fields;
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
