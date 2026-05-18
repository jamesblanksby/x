<?php

use Platform\Module\Admin\Middleware\AuthMiddleware;

/* ////////////////////////////////////////////////////////////////////////////// */
/* //////////////////////////////////////////////////////////////////// ROUTE /// */
/* ////////////////////////////////////////////////////////////////////////////// */

/* --------------------------------------------------------------------- AUTH --- */
$auth = [
    [['GET', 'POST'], '/login', 'AuthController::login'],
    [['GET'], '/logout', 'AuthController::logout'],
];

/* --------------------------------------------------------------------- PAGE --- */
$page = [
    [['GET'], '/', 'PageController::index'],
    [['GET'], '/page', 'PageController::list'],
];

/* ----------------------------------------------------------------- PASSWORD --- */
$password = [
    [['GET', 'POST'], '/password/recover', 'PasswordController::recover'],
    [['GET', 'POST'], '/password/{token}/update', 'PasswordController::update'],
];

/* ------------------------------------------------------------------ SETTING --- */
$setting = [];

/* --------------------------------------------------------------------- USER --- */
$user = [
    [['GET'], '/user', 'UserController::list'],
    [['GET', 'POST'], '/user/insert', 'UserController::insert'],
    [['GET', 'POST'], '/user/{user:uuid}/update', 'UserController::update'],
    [['DELETE'], '/user/{user:uuid}/delete', 'UserController::delete'],
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
        'page',
        'password',
        'setting',
        'user'
    ),
];
