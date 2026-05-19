<?php

return [
    'parameters' => [
        'level' => 6,
        'paths' => [
            __DIR__ . '/app/config/',
            __DIR__ . '/app/src/',
            __DIR__ . '/platform/config/',
            __DIR__ . '/platform/src/',
            __DIR__ . '/framework/config/',
            __DIR__ . '/framework/src/',
        ],
        'bootstrapFiles' => [
            __DIR__ . '/app/vendor/autoload.php',
        ],
        'ignoreErrors' => [
            '#no value type specified in iterable type (array|iterable)#',
        ],
    ],
];
