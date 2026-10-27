<?php

declare(strict_types=1);

/**
 * Entrypoint serverless function untuk Vercel.
 */

// Siapkan direktori /tmp untuk environment serverless
$storagePath = getenv('APP_STORAGE') ?: '/tmp/storage';

// Redirect bootstrap cache ke /tmp yang writable
$cacheDir = $storagePath.'/bootstrap/cache';
putenv("APP_PACKAGES_CACHE={$cacheDir}/packages.php");
putenv("APP_SERVICES_CACHE={$cacheDir}/services.php");
putenv("APP_CONFIG_CACHE={$cacheDir}/config.php");
putenv("APP_ROUTES_CACHE={$cacheDir}/routes.php");
putenv("APP_EVENTS_CACHE={$cacheDir}/events.php");
$_ENV['APP_PACKAGES_CACHE'] = "{$cacheDir}/packages.php";
$_ENV['APP_SERVICES_CACHE'] = "{$cacheDir}/services.php";
$_ENV['APP_CONFIG_CACHE'] = "{$cacheDir}/config.php";
$_ENV['APP_ROUTES_CACHE'] = "{$cacheDir}/routes.php";
$_ENV['APP_EVENTS_CACHE'] = "{$cacheDir}/events.php";

$directories = [
    $storagePath.'/app',
    $storagePath.'/app/public',
    $storagePath.'/framework',
    $storagePath.'/framework/cache',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
    $cacheDir,
];

foreach ($directories as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

try {
    require __DIR__.'/../public/index.php';
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo '<h2>Peternak Milenial - Vercel Serverless Error</h2>';
    echo '<p><strong>Pesan:</strong> '.htmlspecialchars($e->getMessage()).'</p>';
    echo '<p><strong>File:</strong> '.htmlspecialchars($e->getFile()).':'.$e->getLine().'</p>';
    echo '<pre style="background:#f4f4f4;padding:12px;border-radius:6px;overflow:auto;">'.htmlspecialchars($e->getTraceAsString()).'</pre>';
}
