<?php

namespace Framework\View\Extension;

use Framework\Core\Context;
use Framework\Http\Request\Request;
use Framework\View\View;

class AssetExtension implements ExtensionInterface
{
    /** @var Context */
    private $context;
    /** @var Request */
    private $request;
    /** @var View */
    private $view;

    public function __construct(
        Context $context,
        Request $request
    ) {
        $this->context = $context;
        $this->request = $request;
    }

    public function register(View $view): void
    {
        $this->view = $view;

        $view->addFunction('asset', [$this, 'asset']);
    }

    public function asset(string $path): string
    {
        $asset = trim($this->view->getOption('asset', ''), '/');

        $path = $asset . '/' . ltrim($path, '/');
        $url = $this->request->getUrlForPath($path);

        $path = $this->context->path($path);

        if (file_exists($path)) {
            $url .= '?v=' . substr(md5((string) filemtime($path)), 0, 8);
        }

        return $url;
    }
}
