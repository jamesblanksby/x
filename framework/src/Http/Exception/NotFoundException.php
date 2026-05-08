<?php

namespace Framework\Http\Exception;

class NotFoundException extends HttpException
{
    public function __construct(string $message = '')
    {
        parent::__construct(404, $message);
    }
}
