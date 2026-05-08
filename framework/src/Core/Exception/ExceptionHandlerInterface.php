<?php

namespace Framework\Core\Exception;

use Framework\Http\Response\Response;

interface ExceptionHandlerInterface
{
    public function handle(\Throwable $e): Response;
}
