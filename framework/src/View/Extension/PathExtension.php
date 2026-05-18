<?php

namespace Framework\View\Extension;

use Framework\Core\KernelConfig;
use Framework\View\View;

class PathExtension implements ExtensionInterface
{
    /** @var KernelConfig */
    private $kernelConfig;

    public function __construct(KernelConfig $kernelConfig)
    {
        $this->kernelConfig = $kernelConfig;
    }

    public function register(View $view): void
    {
        $view->addFunction('path', [$this, 'path']);
    }

    public function path(string $path): string
    {
        return $this->kernelConfig->path($path);
    }
}
