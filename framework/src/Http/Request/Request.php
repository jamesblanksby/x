<?php

namespace Framework\Http\Request;

use Framework\Http\Bag\FileBag;
use Framework\Http\Bag\HeaderBag;
use Framework\Http\Bag\InputBag;
use Framework\Http\Bag\ParamBag;

class Request
{
    /** @var ParamBag */
    private $server;
    /** @var HeaderBag */
    private $headers;
    /** @var ParamBag */
    private $query;
    /** @var ParamBag */
    private $body;
    /** @var FileBag */
    private $files;
    /** @var InputBag */
    private $input;
    /** @var ParamBag */
    private $cookies;
    /** @var string */
    private $method;
    /** @var string */
    private $uri;
    /** @var string */
    private $path;
    /** @var array */
    private $attributes = [];

    public function __construct(
        array $server = [],
        array $headers = [],
        array $query = [],
        array $body = [],
        array $files = [],
        array $cookies = []
    ) {
        $this->server = new ParamBag($server);
        $this->headers = new HeaderBag($headers);
        $this->query = new ParamBag($query);
        $this->body = new ParamBag($body);
        $this->files = new FileBag($files);
        $this->input = new InputBag(
            $this->query,
            $this->body,
            $this->files
        );
        $this->cookies = new ParamBag($cookies);
        $this->method = strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
        $this->uri = $this->server->get('REQUEST_URI', '/');
        $this->path = parse_url($this->uri, PHP_URL_PATH) ?? '/';
    }

    public function getServer(): ParamBag
    {
        return $this->server;
    }

    public function getHeaders(): HeaderBag
    {
        return $this->headers;
    }

    public function getQuery(): ParamBag
    {
        return $this->query;
    }

    public function getBody(): ParamBag
    {
        return $this->body;
    }

    public function getFiles(): FileBag
    {
        return $this->files;
    }

    public function getInput(): InputBag
    {
        return $this->input;
    }

    public function getCookies(): ParamBag
    {
        return $this->cookies;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getScheme(): string
    {
        $https = $this->server->get('HTTPS');

        return ($https && $https !== 'off') ? 'https' : 'http';
    }

    public function getHost(): ?string
    {
        return $this->headers->get('host') ?? $this->server->get('SERVER_NAME');
    }

    public function getSchemeAndHost(): string
    {
        return $this->getScheme() . '://' . $this->getHost();
    }

    public function getBasePath(): string
    {
        return dirname($this->server->get('SCRIPT_NAME', ''));
    }

    public function getBaseUrl(): string
    {
        return $this->getSchemeAndHost() . $this->getBasePath();
    }

    public function getRelativePath(): string
    {
        return substr($this->path, strlen(rtrim($this->getBasePath(), '/')));
    }

    public function getQueryString(): ?string
    {
        return parse_url($this->uri, PHP_URL_QUERY) ?: null;
    }

    public function getUrl(): string
    {
        $url = $this->getSchemeAndHost() . $this->getPath();

        $queryString = $this->getQueryString();

        if ($queryString) {
            $url .= '?' . $queryString;
        }

        return $url;
    }

    public function getUrlForPath(string $path): string
    {
        return $this->getBaseUrl() . '/' . ltrim($path, '/');
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute(string $name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }

    /** @return static */
    public function addAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->addAttribute($key, $value);
        }

        return $this;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function addAttribute(string $key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function isSecure(): bool
    {
        return $this->getScheme() === 'https';
    }

    public function isMethod(string $method): bool
    {
        return $this->getMethod() === strtoupper($method);
    }

    public function isPost(): bool
    {
        return $this->isMethod('POST');
    }

    public function isGet(): bool
    {
        return $this->isMethod('GET');
    }

    public function isPut(): bool
    {
        return $this->isMethod('PUT');
    }

    public function isDelete(): bool
    {
        return $this->isMethod('DELETE');
    }

    public function isJson(): bool
    {
        $accept = $this->headers->get('Accept', '');

        return strpos($accept, 'application/json') !== false;
    }
}
