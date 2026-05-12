<?php

namespace Framework\Http\Bag;

class InputBag
{
    /** @var ParamBag */
    private $query;
    /** @var ParamBag */
    private $body;
    /** @var FileBag */
    private $files;

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
}
