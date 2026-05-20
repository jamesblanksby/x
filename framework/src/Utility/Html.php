<?php

namespace Framework\Utility;

class Html
{
    public static function attribute(array $attributes): string
    {
        $parts = [];

        foreach ($attributes as $key => $value) {
            if (self::blank($value)) {
                continue;
            }

            if ($value === true) {
                $parts[] = $key;
            } else {
                $parts[] = "{$key}=\"{$value}\"";
            }
        }

        return implode(' ', $parts);
    }

    public static function class(?string ...$classes): string
    {
        return implode(' ', array_filter($classes));
    }

    public static function sanitize(string $html, ?array $allowed = null, ?array $blocked = null): string
    {
        if ($blocked && !$allowed) {
            $patterns = array_map(function (string $tag) {
                return sprintf('/<\/?%s[^>]*>/i', preg_quote($tag, '/'));
            }, $blocked);

            return preg_replace($patterns, '', $html);
        }

        if ($allowed) {
            $allowed = array_diff($allowed, $blocked ?? []);

            if (!$allowed) {
                return strip_tags($html);
            }

            $tags = array_map(function (string $tag) {
                return sprintf('<%s>', trim($tag, '<>'));
            }, $allowed);

            return strip_tags($html, implode('', $tags));
        }

        return strip_tags($html);
    }


    public static function style(array $styles): string
    {
        $parts = [];

        foreach ($styles as $property => $value) {
            if (self::blank($value)) {
                continue;
            }

            $parts[] = "{$property}: {$value}";
        }

        return implode('; ', $parts);
    }

    /** @param mixed $value */
    private static function blank($value): bool
    {
        return Value::blank($value) || $value === false;
    }
}
