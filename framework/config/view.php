<?php

use Framework\View\Extension\AppExtension;
use Framework\View\Extension\AssetExtension;
use Framework\View\Extension\PathExtension;
use Framework\View\Extension\UrlExtension;

/* ////////////////////////////////////////////////////////////////////////////// */
/* ///////////////////////////////////////////////////////////////////// VIEW /// */
/* ////////////////////////////////////////////////////////////////////////////// */

/* --------------------------------------------------------------------- VIEW --- */
return [
    'extensions' => [
        AppExtension::class,
        AssetExtension::class,
        PathExtension::class,
        UrlExtension::class,
    ],
];
