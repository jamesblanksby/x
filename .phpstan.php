<?php

return [
    'parameters' => [
        'level' => 6,
        'paths' => [
            __DIR__ . '/app/config/',
            __DIR__ . '/app/src/',
            __DIR__ . '/framework/src/',
        ],
        'ignoreErrors' => [
            '#no value type specified in iterable type (array|iterable)#',
        ],
    ],
];
