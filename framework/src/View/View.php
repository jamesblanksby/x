<?php

namespace Framework\View;

use Framework\View\Extension\ExtensionInterface;

class View
{
    /** @var array */
    private $options = [];
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
    private $sections = [];

    public function render(string $template, array $data = []): string
    {
        $output = $this->renderTemplate($template, $data);

        while ($this->layout !== null) {
            $layout = $this->layout;
            $this->layout = null;

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

    public function start(string $name, bool $extend = true): void
    {
        $this->stack[] = new Section($name, $extend);
        $this->startBuffer();
    }

    public function stop(): void
    {
        $section = array_pop($this->stack);

        if ($section === null) {
            throw new \UnderflowException('Cannot end a section that has not been started.');
        }

        $name = $section->getName();
        $content = $this->captureBuffer();

        $parent = $this->sections[$name] ?? null;

        if ($parent !== null) {
            $content = $parent->shouldExtend() ? $content . $parent->getContent() : $parent->getContent();
        }

        $this->sections[$name] = new Section(
            $name,
            $section->shouldExtend(),
            $content
        );
    }

    public function section(string $name, string $default = ''): string
    {
        $section = $this->sections[$name] ?? null;

        if ($section === null) {
            return $default;
        }

        return $section->getContent();
    }

    public function include(string $template, array $data = []): string
    {
        $clone = clone $this;
        $clone->layout = null;

        return $clone->render($template, $data);
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
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

    /** @return mixed */
    public function __call(string $name, array $args)
    {
        $function = $this->functions[$name] ?? null;

        if ($function === null) {
            throw new \BadMethodCallException("Method `{$name}` does not exist.");
        }

        return $function(...$args);
    }

    private function renderTemplate(string $template, array $data): string
    {
        $data = $this->resolveData($data);
        extract($data);

        $v = $this;

        $this->startBuffer();

        try {
            require $this->resolvePath($template);
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

    private function resolveData(array $data): array
    {
        return array_map(function ($value) {
            return $value instanceof \Closure ? $value() : $value;
        }, array_merge($this->globals, $data));
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
