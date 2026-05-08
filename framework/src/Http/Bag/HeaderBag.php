<?php

namespace Framework\Http\Bag;

class HeaderBag extends ParamBag
{
    public function has(string $name): bool
    {
        return parent::has($this->normalize($name));
    }

    public function set(string $name, $value)
    {
        return parent::set($this->normalize($name), $value);
    }

    public function get(string $name, $default = null)
    {
        return parent::get($this->normalize($name), $default);
    }

    public function toArray(): array
    {
        $headers = [];

        foreach ($this->all() as $name => $value) {
            $name = $this->denormalize($name);
            $headers[$name] = $value;
        }

        return $headers;
    }

    private function normalize(string $name): string
    {
        return strtolower(str_replace('_', '-', $name));
    }

    private function denormalize(string $name): string
    {
        $name = str_replace('_', '-', $name);
        $parts = explode('-', $name);

        $parts = array_map(function ($part) {
            return ucfirst(strtolower($part));
        }, $parts);

        return implode('-', $parts);
    }
}
