<?php

namespace Framework\Http\Response;

class RedirectResponse extends Response
{
    public function __construct(string $url, int $status = 302)
    {
        parent::__construct('', $status);

        $this->setHeader('location', $url);
    }
}
