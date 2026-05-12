<?php

namespace Framework\View\Extension;

use Framework\Core\Context;
use Framework\Http\Request\Request;
use Framework\View\View;
use Platform\Security\Authenticator;

class AppExtension implements ExtensionInterface
{
    /** @var Authenticator */
    private $authenticator;
    /** @var Context */
    private $context;
    /** @var Request */
    private $request;

    public function __construct(
        Authenticator $authenticator,
        Context $context,
        Request $request
    ) {
        $this->authenticator = $authenticator;
        $this->context = $context;
        $this->request = $request;
    }

    public function register(View $view): void
    {
        // @TODO
        // $session = $this->request->getSession();

        $view->addGlobal('app', [
            'debug' => $this->context->isDebug(),
            'environment' => $this->context->getEnvironment(),
            // 'flash' => $session->getFlash(),
            'request' => $this->request,
            // 'session' => $session,
            'user' => $this->authenticator->user(),
        ]);
    }
}
