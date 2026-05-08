<?php

use Platform\Module\Admin\Middleware\AuthMiddleware;

/* ////////////////////////////////////////////////////////////////////////////// */
/* //////////////////////////////////////////////////////////////////// ROUTE /// */
/* ////////////////////////////////////////////////////////////////////////////// */

/* --------------------------------------------------------------------- AUTH --- */
$auth = [
    // GET
    ['GET', '/login', 'AuthController::login'],
    ['GET', '/logout', 'AuthController::logout'],

    // POST
    ['POST', '/authenticate', 'AuthController::authenticate'],
];

/* --------------------------------------------------------------------- PAGE --- */
$page = [
    // GET
    ['GET', '/', 'PageController::index'],
    ['GET', '/page', 'PageController::list'],
];

/* -------------------------------------------------------------------- ADMIN --- */
return [
    'scope' => [
        'namespace' => 'Platform\Module\Admin\Controller',
        'path' => '/admin',
        'name' => 'admin',
    ],
    'middleware' => [
        AuthMiddleware::class,
    ],
    'routes' => compact(
        'auth',
        'page'
    ),
];
