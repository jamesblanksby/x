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

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

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

    public function section(string $name, bool $extend = true): void
    {
        $this->stack[] = new Section($name, $extend);
        $this->startBuffer();
    }

    public function endsection(): void
    {
        $section = array_pop($this->stack);

        if (!$section) {
            throw new \UnderflowException('Cannot end a section that has not been started.');
        }

        $content = $this->captureBuffer();

        echo $this->resolveSectionContent($section, $content);
    }

    public function include(string $template, array $data = []): void
    {
        $clone = clone $this;
        $clone->layout = null;

        echo $clone->render($template, $data);
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

        if (!$function) {
            throw new \BadMethodCallException("Method `{$name}` does not exist.");
        }

        return $function(...$args);
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

    private function resolveSectionContent(Section $section, string $content): string
    {
        $name = $section->getName();

        $child = $this->sections[$name] ?? null;

        if (!$child) {
            $this->sections[$name] = new Section(
                $name,
                $section->shouldExtend(),
                $content
            );

            return $content;
        }

        if ($child->shouldExtend()) {
            return $content . $child->content;
        }

        return $child->content;
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
