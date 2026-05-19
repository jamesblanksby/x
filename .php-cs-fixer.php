<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/app/config/',
        __DIR__ . '/app/src/',
        __DIR__ . '/platform/config/',
        __DIR__ . '/platform/src/',
        __DIR__ . '/framework/config/',
        __DIR__ . '/framework/src/',
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'increment_style' => false,
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'phpdoc_align' => false,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
