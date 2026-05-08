<?php

namespace Framework\Debug;

class Dumper
{
    /** @param mixed $args */
    public static function d(...$args): void
    {
        foreach ($args as $value) {
            echo self::format($value);
        }
    }

    /** @param mixed $args */
    public static function dd(...$args): void
    {
        self::d(...$args);
        die;
    }

    /** @param mixed $value */
    private static function format($value): string
    {
        ob_start();

        if (is_array($value) || is_object($value)) {
            print_r($value);
        } else {
            var_dump($value);
        }

        $content = ob_get_clean();

        $style = self::style();

        return "<pre style=\"{$style}\">{$content}</pre>";
    }

    private static function style(): string
    {
        $styles = [
            'display' => 'block',
            'font' => 'monospace',
            'white-space' => 'pre',
        ];

        $style = '';
        foreach ($styles as $key => $value) {
            $style .= "{$key}:{$value};";
        }

        return $style;
    }
}
