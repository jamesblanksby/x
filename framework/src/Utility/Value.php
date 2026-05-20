<?php

namespace Framework\Utility;

class Value
{
    /** @param mixed $value */
    public static function blank($value): bool
    {
        return $value === null || $value === '';
    }
}
