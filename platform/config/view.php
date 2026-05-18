<?php

use Platform\View\Extension\FormExtension;
use Platform\View\Extension\HtmlExtension;
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
        FormExtension::class,
        HtmlExtension::class,
        PageExtension::class,
    ],
    'options' => [
        'asset' => 'src/',
    ],
];
