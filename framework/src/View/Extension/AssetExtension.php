<?php

namespace Framework\View\Extension;

use Framework\Http\Request\Request;
use Framework\View\View;

class AssetExtension implements ExtensionInterface
{
    /** @var Request */
    private $request;
    /** @var View */
    private $view;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function register(View $view): void
    {
        $this->view = $view;

        $view->addFunction('asset', [$this, 'asset']);
    }

    public function asset(string $path): string
    {
        $base = '';
        $root = trim($this->view->getOption('asset', ''), '/');

        if (strpos($root, 'http') !== 0) {
            $base = rtrim($this->request->getBaseUrl(), '/');
        }

        return $base . '/' . $root . '/' . ltrim($path, '/');
    }
}
