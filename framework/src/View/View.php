<?php

namespace Framework\View;

use Framework\Support\Collection;
use Framework\Support\ValueObject;
use Framework\View\Extension\ExtensionInterface;

class View extends ValueObject
{
    /** @var Collection */
    public $options;

    /** @var array */
    private $paths = [];
    /** @var array */
    private $functions = [];
    /** @var array */
    private $globals = [];
    /** @var ?string */
    private $layout = null;
    /** @var array */
    private $stack = [];
    /** @var array */
    private $blocks = [];

    public function __construct(array $options = [])
    {
        $this->options = new Collection($options);
    }

    public function render(string $template, array $data = []): string
    {
        $output = $this->renderTemplate($template, $data);

        while ($this->layout !== null) {
            $layout = $this->layout;
            $this->layout = null;

            $data = array_merge($data, [
                'content' => $output,
            ]);

            $output = $this->renderTemplate($layout, $data);
        }

        return $output;
    }

    /** @return static */
    public function extend(string $layout)
    {
        $this->layout = $layout;
        return $this;
    }

    public function block(string $name): void
    {
        $this->stack[] = $name;
        $this->startBuffer();
    }

    public function endblock(): void
    {
        $name = array_pop($this->stack);
        $this->blocks[$name] = $this->captureBuffer();
    }

    public function section(string $name, string $default = ''): void
    {
        echo $this->blocks[$name] ?? $default;
    }

    public function include(string $template, array $data = []): void
    {
        $clone = clone $this;
        $clone->layout = null;

        echo $clone->render($template, $data);
    }

    /** @return mixed */
    public function __call(string $name, array $args)
    {
        if (!isset($this->functions[$name])) {
            throw new \BadMethodCallException("Method `{$name}` does not exist.");
        }

        return ($this->functions[$name])(...$args);
    }

    public function addPath(string $path): void
    {
        $this->paths[] = $path;
    }

    /** @param mixed $value */
    public function addGlobal(string $key, $value): void
    {
        $this->globals[$key] = $value;
    }

    public function addFunction(string $name, callable $callable): void
    {
        $this->functions[$name] = $callable;
    }

    public function registerExtension(ExtensionInterface $extension): void
    {
        $extension->register($this);
    }

    private function renderTemplate(string $template, array $data): string
    {
        $path = $this->resolvePath($template);

        $v = $this;

        $data = array_merge($this->globals, $data);
        extract($data);

        $this->startBuffer();

        try {
            require $path;
        } catch (\Throwable $e) {
            $this->discardBuffer();
            throw $e;
        }

        return $this->captureBuffer();
    }

    private function resolvePath(string $template): string
    {
        if (substr($template, -4) !== '.php') {
            $template .= '.php';
        }

        foreach ($this->paths as $path) {
            $path = rtrim($path, '/') . '/' . ltrim($template, '/');

            if (file_exists($path)) {
                return $path;
            }
        }

        throw new \InvalidArgumentException("View `{$template}` not found.");
    }

    private function startBuffer(): void
    {
        ob_start();
    }

    private function captureBuffer(): string
    {
        return ob_get_clean() ?: '';
    }

    private function discardBuffer(): void
    {
        if (ob_get_level() > 0) {
            ob_end_clean();
        }
    }
}
