<?php

// Do not block the client just for metrics
// Immediately send response header
header('HTTP/1.0 200 OK');
header('Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: {now} GMT');
header("Content-Length: 0");
header('Connection: close');
flush();

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    // Stop if not ajax request
    // to prevent unwanted calls
    return;
}

require_once __DIR__ . '/vendor/autoload.php';

use mre\Beacon\Bootstrap;

$_oRouter = new Respect\Rest\Router;

$_oRouter->get('/**', function ($url)
{
    $_sAppNamespace = implode('/', $url);
    Bootstrap::run($_sAppNamespace);
});


