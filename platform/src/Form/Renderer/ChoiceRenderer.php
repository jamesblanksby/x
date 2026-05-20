<?php

namespace Platform\Form\Renderer;

class ChoiceRenderer extends FieldRenderer
{
    public function widget(): string
    {
        $html = '';

        $attribute = self::buildAttributes([
            'class' => 'choice',
        ]);

        $html .= "<div {$attribute}>";
        $html .= $this->choices();
        $html .= '</div>';

        return $html;
    }

    private function choices(): string
    {
        $html = '';

        foreach ($this->getOption('choices') as $value => $label) {
            $html .= $this->choice($label, $value);
        }

        return $html;
    }

    /** @param mixed $value */
    private function choice(string $label, $value): string
    {
        $html = '';

        $attribute = self::buildAttributes([
            'class' => 'item',
        ]);

        $html .= "<div {$attribute}">
        $html .= $this->input($value);
        $html .= $this->hidden($value);
        $html .= $this->option($label, $value);
        $html .= '</div>';

        return $html;
    }

    /** @param mixed $value */
    private function input($value): string
    {
        $type = $this->getOption('type');
        $readonly = $this->isReadonly();

        $attribute = self::buildAttributes([
            'type' => $type,
            'id' => $this->resolveChoiceId($value),
            'name' => !$readonly ? $this->element->getName() : null,
            'value' => $value,
            'required' => $this->getOption('required'),
            'checked' => $this->isChecked($value) ?: null,
            'disabled' => $readonly ?: null,
        ]);

        return "<input {$attribute}>";
    }

    /** @param mixed $value */
    private function hidden($value): string
    {
        if (!$this->isReadonly() || !$this->isChecked($value)) {
            return '';
        }

        $attribute = self::buildAttributes([
            'type' => 'hidden',
            'name' => $this->element->getName(),
            'value' => $value,
        ]);

        return "<input {$attribute}>";
    }

    /** @param mixed $value */
    private function option(string $label, $value): string
    {
        $attribute = self::buildAttributes([
            'class' => 'option',
            'for' => $this->resolveChoiceId($value),
        ]);

        return "<label {$attribute}>{$label}</label>";
    }

    /** @param mixed $value */
    private function resolveChoiceId($value): string
    {
        return $this->resolveId() . '_' . $value;
    }

    /** @param mixed $value */
    private function isChecked($value): bool
    {
        return in_array($value, (array) $this->element->getValue());
    }

    private function isReadonly(): bool
    {
        return (bool) $this->getOption('readonly');
    }
}
