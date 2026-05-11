<?php

namespace Platform\Utility;

class Html
{
    public static function attribute(array $attributes): string
    {
        $parts = [];

        foreach ($attributes as $key => $value) {
            if (self::isEmpty($value)) {
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

    /**
     * @param mixed $value
     * @param mixed $compare
     */
    public static function equal($value, $compare, bool $strict = true): bool
    {
        if (is_array($compare)) {
            return in_array($value, $compare, $strict);
        }

        return $strict ? $value === $compare : $value == $compare;
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

    /**
     * @param mixed $value
     * @param mixed $compare
     */
    public static function state($value, $compare, string $state): ?string
    {
        return self::equal($value, $compare) ? $state : null;
    }

    public static function style(array $styles): string
    {
        $parts = [];

        foreach ($styles as $property => $value) {
            if (self::isEmpty($value)) {
                continue;
            }

            $parts[] = "{$property}: {$value}";
        }

        return implode('; ', $parts);
    }

    /** @param mixed $value */
    private static function isEmpty($value): bool
    {
        return $value === null || $value === false;
    }
}
