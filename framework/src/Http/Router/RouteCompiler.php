<?php

namespace Framework\Http\Router;

class RouteCompiler
{
    private const PARAM_REGEX = '/\{(\w+)(?::([^}]+))?\}(\?)?/';
    private const DEFAULT_PATTERN = '[^/]+';

    public function compile(string $path, string $method, string $handler, string $name, array $middleware): Route
    {
        $method = strtoupper($method);

        [$regex, $paramNames, $paramOptional] = $this->buildRegex($path);

        return new Route(
            $method,
            $path,
            $regex,
            $paramNames,
            $paramOptional,
            $handler,
            $name,
            $middleware
        );
    }

    private function buildRegex(string $path): array
    {
        $body = '';

        $paramNames = [];
        $paramOptional = [];

        $offset = 0;

        preg_match_all(self::PARAM_REGEX, $path, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $a => $match) {
            [$fullToken, $tokenStart] = $match;

            $name = $matches[1][$a][0];
            $pattern = $matches[2][$a][0] !== '' ? $matches[2][$a][0] : self::DEFAULT_PATTERN;
            $optional = $matches[3][$a][0] === '?';

            if (in_array($name, $paramNames)) {
                throw new \RuntimeException("Duplicate parameter name `{$name}` in path `{$path}`.");
            }

            $this->assertNonCapturing($pattern, $name, $path);

            $literal = substr($path, $offset, ($tokenStart - $offset));
            $body .= preg_quote(rtrim($literal, '/'), '~');

            $group = "(?P<{$name}>{$pattern})";

            if ($optional) {
                $group = "(?:/({$group}))?";
            } else {
                $group = "/{$group}";
            }

            $body .= $group;

            $paramNames[] = $name;
            $paramOptional[] = $optional;

            $offset = ($tokenStart + strlen($fullToken));
        }

        $body .= preg_quote(substr($path, $offset), '~');

        return ["~^{$body}/?$~u", $paramNames, $paramOptional];
    }

    private function assertNonCapturing(string $pattern, string $name, string $path): void
    {
        preg_match('/\((?!\?)/', $pattern, $matches);

        if ($matches) {
            throw new \RuntimeException(
                "Parameter `{$name}` in path `{$path}` contains a capturing group. " .
                'Use a non-capturing group (?:...) instead.'
            );
        }
    }
}
