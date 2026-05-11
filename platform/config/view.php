<?php

use Framework\View\Extension\AppExtension;
use Framework\View\Extension\AssetExtension;
use Framework\View\Extension\PathExtension;
use Framework\View\Extension\UrlExtension;
use Platform\View\Extension\PageExtension;

/* ////////////////////////////////////////////////////////////////////////////// */
/* ///////////////////////////////////////////////////////////////////// VIEW /// */
/* ////////////////////////////////////////////////////////////////////////////// */

/* --------------------------------------------------------------------- VIEW --- */
return [
    'paths' => [
        dirname(__DIR__, 1) . '/view/',
    ],
    'extensions' => [
        AppExtension::class,
        AssetExtension::class,
        PageExtension::class,
        PathExtension::class,
        UrlExtension::class,
    ],
    'options' => [
        'asset' => 'src/',
    ],
];
