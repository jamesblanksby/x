<?php

namespace Platform\Controller;

use Framework\Controller\Controller;
use Framework\Http\Response\Response;

abstract class AdminController extends Controller
{
    protected function respond(array $data): Response
    {
        // @TODO redirect

        return $this->json($data);
    }
}
