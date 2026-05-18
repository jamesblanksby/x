<?php

namespace Framework\View\Extension;

use Framework\Core\KernelConfig;
use Framework\Http\Request\RequestContext;
use Framework\View\View;

class AssetExtension implements ExtensionInterface
{
    /** @var KernelConfig */
    private $kernelConfig;
    /** @var RequestContext */
    private $requestContext;
    /** @var View */
    private $view;

    public function __construct(
        KernelConfig $kernelConfig,
        RequestContext $requestContext
    ) {
        $this->kernelConfig = $kernelConfig;
        $this->requestContext = $requestContext;
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
        $url = $this->requestContext->getRequest()->getUrlForPath($path);

        $path = $this->kernelConfig->path($path);

        if (file_exists($path)) {
            $url .= '?v=' . substr(md5((string) filemtime($path)), 0, 8);
        }

        return $url;
    }
}
