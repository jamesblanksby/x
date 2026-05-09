<?php

namespace Framework\Http\Request;

use Framework\Http\Bag\FileBag;
use Framework\Http\Bag\HeaderBag;
use Framework\Http\Bag\ParamBag;
use Framework\Http\Session\Session;
use Framework\Support\ValueObject;

class Request extends ValueObject
{
    /** @var ParamBag */
    public $server;
    /** @var HeaderBag */
    public $headers;
    /** @var ParamBag */
    public $query;
    /** @var ParamBag */
    public $body;
    /** @var FileBag */
    public $files;
    /** @var ParamBag */
    public $cookies;
    /** @var Session */
    public $session;
    /** @var string */
    public $method;
    /** @var string */
    public $uri;
    /** @var string */
    public $path;

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
        $this->cookies = new ParamBag($cookies);

        $this->method = strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
        $this->uri = $this->server->get('REQUEST_URI', '/');
        $this->path = parse_url($this->uri, PHP_URL_PATH) ?? '/';
    }

    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    public function isSecure(): bool
    {
        return $this->getScheme() === 'https';
    }

    public function isXmlHttpRequest(): bool
    {
        $header = $this->server->get('HTTP_X_REQUESTED_WITH');

        if (!$header) {
            return false;
        }

        return in_array(strtolower($header), ['fetch', 'xmlhttprequest']);
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

    public function getRelativePath(): string
    {
        return substr($this->path, strlen(rtrim($this->getBasePath(), '/')));
    }

    public function getQueryString(): ?string
    {
        return parse_url($this->uri, PHP_URL_QUERY) ?: null;
    }

    public function getBaseUrl(): string
    {
        return $this->getSchemeAndHost() . $this->getBasePath();
    }

    public function getUrl(): string
    {
        $uri = $this->getSchemeAndHost() . $this->uri;

        $queryString = $this->getQueryString();

        if ($queryString) {
            $uri .= '?' . $queryString;
        }

        return $uri;
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

    /** @param mixed $value */
    public function withAttribute(string $key, $value): self
    {
        $clone = clone $this;
        $clone->attributes[$key] = $value;

        return $clone;
    }

    public function withAttributes(array $attributes): self
    {
        $clone = clone $this;

        foreach ($attributes as $key => $value) {
            $clone->attributes[$key] = $value;
        }

        return $clone;
    }
}
