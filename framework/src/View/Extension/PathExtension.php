<?php

namespace Framework\View\Extension;

use Framework\Core\Context;
use Framework\View\View;

class PathExtension implements ExtensionInterface
{
    /** @var Context */
    private $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function register(View $view): void
    {
        $view->addFunction('path', [$this, 'path']);
    }

    public function path(string $path): string
    {
        return $this->context->path($path);
    }
}
