<?php

namespace Framework\Http\Exception;

class HttpException extends \RuntimeException
{
    /** @var int */
    protected $status;

    public function __construct(int $status, string $message = '')
    {
        parent::__construct($message);

        $this->status = $status;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
