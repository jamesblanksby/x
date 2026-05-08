<?php

namespace Framework\Http\Exception;

class MethodNotAllowedException extends HttpException
{
    public function __construct(string $message = '')
    {
        parent::__construct(405, $message);
    }
}
