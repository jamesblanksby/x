<?php

namespace Framework\Http\Exception;

class AccessDeniedException extends HttpException
{
    public function __construct(string $message = '')
    {
        parent::__construct(403, $message);
    }
}
