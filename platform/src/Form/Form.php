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
    /** @var bool */
    private $submitted = false;
    /** @var array */
    private $data = [];

    public function __construct(
        TypeInterface $type,
        array $options = [],
        array $children = []
    ) {
        $this->type = $type;
        $this->options = $options;
        $this->children = $children;
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
        $this->data = $request->getInput();
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
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function getValue(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
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
}
