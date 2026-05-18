<?php

namespace Framework\View\Extension;

use Framework\Core\KernelConfig;
use Framework\Http\Bag\FlashBag;
use Framework\Http\Request\Request;
use Framework\Http\Request\RequestContext;
use Framework\Http\Router\Route;
use Framework\Http\Session\Session;
use Framework\View\View;

class AppExtension implements ExtensionInterface
{
    /** @var KernelConfig */
    private $kernelConfig;
    /** @var RequestContext */
    private $requestContext;

    public function __construct(
        KernelConfig $kernelConfig,
        RequestContext $requestContext
    ) {
        $this->kernelConfig = $kernelConfig;
        $this->requestContext = $requestContext;
    }

    public function register(View $view): void
    {
        $view->addGlobal('app', function () {
            return [
                'debug' => $this->kernelConfig->isDebug(),
                'environment' => $this->kernelConfig->getEnvironment(),
                'request' => $this->request(),
                'route' => $this->route(),
                'session' => $this->session(),
                'flash' => $this->flash(),
            ];
        });
    }

    private function flash(): FlashBag
    {
        return $this->requestContext->getSession()->getFlash();
    }

    private function request(): Request
    {
        return $this->requestContext->getRequest();
    }

    private function route(): Route
    {
        return $this->requestContext->getRouteMatch()->getRoute();
    }

    private function session(): Session
    {
        return $this->requestContext->getSession();
    }
}
