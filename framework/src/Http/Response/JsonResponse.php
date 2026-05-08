<?php

namespace Framework\Http\Response;

class JsonResponse extends Response
{
    /** @param mixed $data */
    public function __construct($data, int $status = 200, array $headers = [])
    {
        parent::__construct('', $status, $headers);

        $body = json_encode($data);

        $this->setHeader('content-type', 'application/json');
        $this->setBody($body);
    }
}
