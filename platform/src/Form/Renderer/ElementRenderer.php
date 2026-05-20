<?php

namespace Platform\Form\Renderer;

use Platform\Form\FormElement;
use Platform\Form\Type\TypeInterface;

abstract class ElementRenderer extends Renderer
{
    /** @var FormElement */
    protected $element;
    /** @var TypeInterface */
    protected $type;

    public function __construct(FormElement $element)
    {
        $this->element = $element;
        $this->type = $element->getType();
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    protected function getOption(string $key, $default = null)
    {
        return $this->element->getOption($key, $default);
    }

    protected function renderLabel(string $tag, ?string $for = null): string
    {
        $label = $this->resolveLabel();

        if ($label === false) {
            return '';
        }

        $attribute = self::buildAttributes([
            'class' => 'label',
            'for' => $for,
        ]);

        return "<$tag {$attribute}>{$label}</$tag>";
    }

    /** @return string|bool */
    protected function resolveLabel()
    {
        $label = $this->getOption('label');

        if ($label === false) {
            return false;
        }

        if ($label !== null) {
            return $label;
        }

        return $this->humanizeName($this->element->getName());
    }

    private function humanizeName(string $name): string
    {
        $name = $this->normalizeFieldName($name);

        return mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
    }

    private function normalizeFieldName(string $name): string
    {
        $name = preg_replace('/[\[\]_]+/', ' ', $name);
        $name = preg_replace('/(?<=[a-z0-9])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][a-z])/', ' ', $name);

        return trim(preg_replace('/\s+/', ' ', $name));
    }
}
