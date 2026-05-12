<?php

namespace Framework\Http\Bag;

use Framework\Support\ValueObject;

class InputBag extends ValueObject
{
    /** @var ParamBag */
    public $query;
    /** @var ParamBag */
    public $body;
    /** @var FileBag */
    public $files;

    public function __construct(
        ParamBag $query,
        ParamBag $body,
        FileBag $files
    ) {
        $this->query = $query;
        $this->body = $body;
        $this->files = $files;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->all());
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->all()[$key] ?? $default;
    }

    public function all(): array
    {
        return array_replace_recursive(
            $this->query->all(),
            $this->body->all(),
            $this->files->all()
        );
    }
}
