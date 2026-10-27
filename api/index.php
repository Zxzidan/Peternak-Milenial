<?php

declare(strict_types=1);

/**
 * Entrypoint serverless function untuk Vercel.
 *
 * Pada Vercel Lambda, sistem file bersifat read-only kecuali direktori /tmp.
 * Skrip ini memastikan direktori runtime Laravel di /tmp tersedia sebelum mem-boot aplikasi.
 */
$storagePath = getenv('APP_STORAGE') ?: '/tmp/storage';

$directories = [
    $storagePath.'/app',
    $storagePath.'/app/public',
    $storagePath.'/framework',
    $storagePath.'/framework/cache',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
];

foreach ($directories as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

// Teruskan request ke public/index.php Laravel
require __DIR__.'/../public/index.php';
