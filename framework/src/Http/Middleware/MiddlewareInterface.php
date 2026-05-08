<?php

namespace Framework\Http\Middleware;

use Framework\Http\Request\Request;
use Framework\Http\Response\Response;

interface MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response;
}
