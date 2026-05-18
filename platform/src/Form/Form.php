<?php

namespace Platform\Form;

use Framework\Http\Request\Request;
use Platform\Form\Type\TypeInterface;

class Form
{
    /** @var TypeInterface */
    private $type;
    /** @var array */
    private $options = [];
    /** @var array */
    private $children = [];
    /** @var array */
    private $elements = [];
    /** @var array */
    private $data = [];
    /** @var bool */
    private $submitted = false;

    public function __construct(
        TypeInterface $type,
        array $options = []
    ) {
        $this->type = $type;
        $this->options = $options;
    }

    public function render(): string
    {
        $rendererClass = $this->type->getRendererClass();

        return (new $rendererClass($this))->render();
    }

    public function handleRequest(Request $request): void
    {
        $method = strtoupper($this->getOption('method'));

        if ($request->getMethod() !== $method) {
            return;
        }

        $this->submitted = true;
        $this->setData($request->getInput()->all());
    }

    public function getType(): TypeInterface
    {
        return $this->type;
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }

    public function addChild(FormElement $child): void
    {
        $this->children[] = $child;
        $this->registerElement($child);
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function setData(array $data): void
    {
        $this->data = $data;

        foreach ($data as $name => $value) {
            $element = $this->elements[$name] ?? null;

            if ($element !== null) {
                $element->setValue($value);
            }
        }
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param mixed $default
     * @return mixed
    */
    public function getValue(string $name, $default = null)
    {
        return $this->data[$name] ?? $default;
    }

    public function isSubmitted(): bool
    {
        return $this->submitted;
    }

    public function isValid(): bool
    {
        foreach ($this->children as $child) {
            if (!$child->isValid($this)) {
                return false;
            }
        }

        return true;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    private function registerElement(FormElement $element): void
    {
        $this->elements[$element->getName()] = $element;

        foreach ($element->getChildren() as $child) {
            $this->registerElement($child);
        }
    }
}
