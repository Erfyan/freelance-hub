<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Support both local (public/) and Hostinger (public_html/ with Laravel in private/)
// When deployed: __DIR__ = public_html, Laravel is in parent/private/
// When local:    __DIR__ = public,      Laravel is in parent/
$laravelBase = is_dir(__DIR__ . '/../private')
    ? __DIR__ . '/../private'
    : __DIR__ . '/..';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $laravelBase . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $laravelBase . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $laravelBase . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
