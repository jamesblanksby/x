<?php

namespace Framework\Core;

class Context
{
    /** @var string */
    private $root;
    /** @var string */
    private $environment;
    /** @var bool */
    private $debug;

    public function __construct(string $root, string $environment, bool $debug)
    {
        $this->root = $root;
        $this->environment = $environment;
        $this->debug = $debug;
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function isDebug(): bool
    {
        return $this->debug;
    }

    public function path(string $path): string
    {
        return $this->root . '/' . ltrim($path, '/');
    }
}
