<?php

namespace Platform\Form\Renderer;

use Framework\Utility\Value;

class SelectRenderer extends FieldRenderer
{
    public function widget(): string
    {
        $html = '';

        $attribute = self::buildAttributes([
            'class' => 'select',
        ]);

        $html .= "<div {$attribute}>";
        $html .= $this->select();
        $html .= $this->hidden();
        $html .= '</div>';

        return $html;
    }

    private function select(): string
    {
        $html = '';

        $readonly = $this->isReadonly();

        $attribute = self::buildAttributes(array_merge([
            'id' => $this->resolveId(),
            'name' => !$readonly ? $this->element->getName() : null,
            'required' => $this->getOption('required'),
            'disabled' => $readonly ?: null,
        ], $this->getOption('attributes')));

        $html .= "<select {$attribute}>";
        $html .= $this->options();
        $html .= '</select>';

        return $html;
    }

    private function options(): string
    {
        $html = '';

        $html .= $this->placeholder();

        foreach ($this->getOption('options') as $value => $label) {
            $html .= $this->option($label, $value);
        }

        return $html;
    }

    private function placeholder(): string
    {
        $placeholder = $this->getOption('placeholder');

        if ($placeholder === null) {
            return '';
        }

        $value = $this->element->getValue();

        $attribute = self::buildAttributes([
            'value' => '',
            'selected' => Value::blank($value) ?: null,
            'disabled' => true,
        ]);

        return "<option {$attribute}>{$placeholder}</option>";
    }

    /** @param mixed $value */
    private function option(string $label, $value): string
    {
        $attribute = self::buildAttributes([
            'value' => $value,
            'selected' => $this->isSelected($value) ?: null,
        ]);

        return "<option {$attribute}>{$label}</option>";
    }

    private function hidden(): string
    {
        if (!$this->isReadonly()) {
            return '';
        }

        $attribute = self::buildAttributes([
            'type' => 'hidden',
            'name' => $this->element->getName(),
            'value' => $this->element->getValue(),
        ]);

        return "<input {$attribute}>";
    }

    /** @param mixed $value */
    private function isSelected($value): bool
    {
        return (string) $value === (string) $this->element->getValue();
    }

    private function isReadonly(): bool
    {
        return (bool) $this->getOption('readonly');
    }
}
