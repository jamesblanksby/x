<?php

namespace Framework\Http\Request;

class RequestFactory
{
    public static function createFromGlobals(): Request
    {
        $server = $_SERVER;
        $headers = self::parseHeaders($server);
        $method = strtoupper($server['REQUEST_METHOD'] ?? 'GET');
        $body = self::parseBody($method, $headers);

        return new Request(
            $server,
            $headers,
            $_GET,
            $body,
            $_FILES,
            $_COOKIE
        );
    }

    private static function parseHeaders(array $server): array
    {
        $headers = [];

        foreach ($server as $name => $value) {
            if (strpos($name, 'HTTP_') !== false) {
                $name = substr($name, 5);
                $headers[$name] = $value;
            } elseif (in_array($name, ['CONTENT_TYPE', 'CONTENT_LENGTH'])) {
                $headers[$name] = $value;
            }
        }

        return $headers;
    }

    private static function parseBody(string $method, array $headers): array
    {
        if (in_array($method, ['GET', 'HEAD', 'OPTIONS'])) {
            return [];
        }

        $contentType = self::extractContentType($headers);

        if (self::isFormPost($method, $contentType)) {
            return $_POST;
        }

        $body = self::readBody();

        if ($body === '') {
            return [];
        }

        if ($contentType === 'application/x-www-form-urlencoded') {
            parse_str($body, $data);
            return $data;
        }

        return self::parseJson($body);
    }

    private static function extractContentType(array $headers): string
    {
        $contentType = $headers['CONTENT_TYPE'] ?? '';

        return strtolower(trim(explode(';', $contentType)[0]));
    }

    private static function isFormPost(string $method, string $contentType): bool
    {
        return $method === 'POST' && in_array($contentType, [
            'application/x-www-form-urlencoded',
            'multipart/form-data',
        ]);
    }

    private static function readBody(): string
    {
        $body = file_get_contents('php://input');

        return $body !== false ? $body : '';
    }

    private static function parseJson(string $json): array
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        return is_array($data) ? $data : [];
    }
}
