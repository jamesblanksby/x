<?php

namespace Framework\Http\Response;

use Framework\Http\Bag\HeaderBag;

class Response
{
    /** @var string */
    private $body;
    /** @var int */
    private $status;
    /** @var HeaderBag */
    private $headers;

    public function __construct(
        string $body = '',
        int $status = 200,
        array $headers = []
    ) {
        $this->body = $body;
        $this->status = $status;
        $this->headers = new HeaderBag($headers);
    }

    /** @return static */
    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /** @return static */
    public function setStatus(int $status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    /** @return static */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $name => $value) {
            $this->setHeader($name, $value);
        }

        return $this;
    }

    /** @return static */
    public function setHeader(string $name, string $value)
    {
        $this->headers->set($name, $value);
        return $this;
    }

    public function getHeaders(): HeaderBag
    {
        return $this->headers;
    }

    public function send(): void
    {
        $this->sendStatus();

        if (!$this->headersSent()) {
            $this->sendHeaders();
        }

        $this->sendBody();
    }

    public function sendStatus(): void
    {
        http_response_code($this->status);
    }

    public function sendHeaders(): void
    {
        $headers = $this->headers->toArray();

        foreach ($headers as $name => $value) {
            header("{$name}: {$value}");
        }
    }

    public function sendBody(): void
    {
        echo $this->body;
    }

    protected function headersSent(): bool
    {
        return headers_sent();
    }
}
