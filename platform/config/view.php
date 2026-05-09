<?php

use Framework\View\Extension\AppExtension;
use Framework\View\Extension\AssetExtension;
use Framework\View\Extension\UrlExtension;

/* ////////////////////////////////////////////////////////////////////////////// */
/* ///////////////////////////////////////////////////////////////////// VIEW /// */
/* ////////////////////////////////////////////////////////////////////////////// */

/* --------------------------------------------------------------------- VIEW --- */
return [
    'paths' => [
        dirname(__DIR__, 1) . '/template/',
    ],
    'extensions' => [
        AppExtension::class,
        AssetExtension::class,
        UrlExtension::class,
    ],
];
