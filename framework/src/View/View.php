<?php

namespace Framework\View;

class View
{
    /** @var ?string */
    private $layout = null;
    /** @var array */
    private $paths = [];
    /** @var array */
    private $stack = [];
    /** @var array */
    private $blocks = [];

    public function add(string $path): void
    {
        $this->paths[] = $path;
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

    private function renderTemplate(string $template, array $data): string
    {
        $path = $this->resolvePath($template);

        $v = $this;

        extract($data);

        $this->startBuffer();
        require $path;

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
}
