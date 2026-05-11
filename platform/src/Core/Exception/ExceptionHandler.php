<?php

namespace Platform\Core\Exception;

use Framework\Core\Context;
use Framework\Core\Exception\ExceptionHandler as FrameworkExceptionHandler;
use Framework\Http\Exception\HttpException;
use Framework\Http\Response\Response;
use Framework\View\View;

class ExceptionHandler extends FrameworkExceptionHandler
{
    /** @var View */
    protected $view;

    public function __construct(
        Context $context,
        View $view
    ) {
        parent::__construct($context);

        $this->view = $view;
    }

    protected function handleHttpException(HttpException $e): Response
    {
        return $this->errorResponse($e, $e->getStatus());
    }

    protected function handleException(\Throwable $e): Response
    {
        if ($this->context->debug) {
            return parent::handleException($e);
        }

        return $this->errorResponse($e, 500);
    }

    private function errorResponse(\Throwable $e, int $status): Response
    {
        $body = $this->view->render('site/template/error', [
            'exception' => $e,
        ]);

        return new Response($body, $status);
    }
}
