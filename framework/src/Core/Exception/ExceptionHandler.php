<?php

namespace Framework\Core\Exception;

use Framework\Core\Context;
use Framework\Http\Exception\HttpException;
use Framework\Http\Response\Response;

class ExceptionHandler implements ExceptionHandlerInterface
{
    /** @var Context */
    protected $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function handle(\Throwable $e): Response
    {
        if ($e instanceof HttpException) {
            return $this->handleHttpException($e);
        }

        return $this->handleException($e);
    }

    protected function handleHttpException(HttpException $e): Response
    {
        $status = $e->getStatus();

        if ($this->context->debug) {
            return $this->debugResponse($e, $status);
        }

        return new Response(
            sprintf('<h1>HTTP %d</h1><p>%s</p>', $status, $e->getMessage()),
            $status
        );
    }

    protected function handleException(\Throwable $e): Response
    {
        if ($this->context->debug) {
            return $this->debugResponse($e, 500);
        }

        return new Response('Internal Server Error', 500);
    }

    private function debugResponse(\Throwable $e, int $status): Response
    {
        return new Response(sprintf(
            '<h1>%s</h1><p>%s</p><pre>%s</pre>',
            get_class($e),
            $e->getMessage(),
            $e->getTraceAsString()
        ), $status);
    }
}
