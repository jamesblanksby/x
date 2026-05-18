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
    ['POST', '/login', 'AuthController::login'],
];

/* --------------------------------------------------------------------- PAGE --- */
$page = [
    // GET
    ['GET', '/', 'PageController::index'],
    ['GET', '/page', 'PageController::list'],
];

/* ----------------------------------------------------------------- PASSWORD --- */
$password = [
    // GET
    ['GET', '/password/{token}/insert', 'PasswordController::insert'],
    ['GET', '/password/recover', 'PasswordController::recover'],
    ['GET', '/password/{token}/update', 'PasswordController::update'],

    // POST
    ['POST', '/password/{token}/insert', 'PasswordController::insert'],
    ['POST', '/password/recover', 'PasswordController::recover'],
    ['POST', '/password/{token}/update', 'PasswordController::update'],
];

/* ------------------------------------------------------------------ SETTING --- */
$setting = [];

/* --------------------------------------------------------------------- USER --- */
$user = [
    // GET
    ['GET', '/user', 'UserController::list'],
    ['GET', '/user/insert', 'UserController::insert'],
    ['GET', '/user/{user:uuid}/update', 'UserController::update'],

    // POST
    ['POST', '/user/insert', 'UserController::insert'],
    ['POST', '/user/{user:uuid}/update', 'UserController::update'],

    // DELETE
    ['DELETE', '/user/{user:uuid}/delete', 'UserController::delete'],
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
