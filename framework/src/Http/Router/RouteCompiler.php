<?php

namespace Framework\Http\Router;

class RouteCompiler
{
    private const PARAM_REGEX = '/\{(\w+)(?::([^}]+))?\}(\?)?/';
    private const ANY_PATTERN = '[^/]+';

    private const PARAM_PATTERNS = [
        'file' => '[a-z0-9._-]+\.[a-z0-9]+',
        'uuid' => '[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}',
        'slug' => '[a-z0-9]+(?:-[a-z0-9]+)*',
        'int'  => '[0-9]+',
        'any'  => '[^/]+',
    ];

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
            $pattern = $this->resolvePattern($matches[2][$a][0] ?? null);
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

        return ["~^{$body}/?$~ui", $paramNames, $paramOptional];
    }

    private function resolvePattern(?string $pattern): string
    {
        if ($pattern === null || $pattern === '') {
            return self::ANY_PATTERN;
        }

        return self::PARAM_PATTERNS[$pattern] ?? $pattern;
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
