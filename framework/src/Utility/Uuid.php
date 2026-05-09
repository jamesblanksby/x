<?php

namespace Framework\Utility;

use Ramsey\Uuid\Uuid as Adapter;

class Uuid
{
    public static function create(): string
    {
        return Adapter::uuid4()->toString();
    }

    public static function isValid(string $uuid): bool
    {
        return Adapter::isValid($uuid);
    }
}
