<?php

namespace Framework\View\Extension;

use Framework\Http\Router\UrlGenerator;
use Framework\View\View;

class UrlExtension implements ExtensionInterface
{
    /** @var UrlGenerator */
    private $urlGenerator;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function register(View $view): void
    {
        $view->addFunction('url', [$this, 'url']);
    }

    public function url(string $name, array $params = [], bool $absolute = true): string
    {
        return $this->urlGenerator->generate($name, $params, $absolute);
    }
}
