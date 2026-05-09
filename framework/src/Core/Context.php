<?php

namespace Framework\Core;

use Framework\Support\ImmutableObject;

class Context extends ImmutableObject
{
    /** @var string */
    public $root;
    /** @var string */
    public $environment;
    /** @var bool */
    public $debug;

    public function __construct(string $root, string $environment, bool $debug)
    {
        $this->root = $root;
        $this->environment = $environment;
        $this->debug = $debug;
    }

    public function path(string $path): string
    {
        return $this->root . DIRECTORY_SEPARATOR . ltrim($path, '/');
    }
}
