<?php

declare(strict_types=1);

/**
 * Entrypoint serverless function untuk Vercel.
 *
 * Menyiapkan direktori runtime /tmp untuk Laravel dan meneruskan request.
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
