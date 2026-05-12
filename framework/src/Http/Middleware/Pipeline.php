<?php

namespace Framework\Http\Middleware;

use Framework\Http\Request\Request;
use Framework\Http\Response\Response;

class Pipeline
{
    public function process(
        Request $request,
        callable $controller,
        array $middleware
    ): Response {
        $core = $controller;

        foreach (array_reverse($middleware) as $layer) {
            $next = $core;

            $core = function (Request $request) use ($layer, $next): Response {
                return $layer->handle($request, $next);
            };
        }

        return $core($request);
    }
}
