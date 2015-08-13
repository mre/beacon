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

if ($_SERVER['REQUEST_METHOD'] !== 'GET')
{
    // Only accept GET requests
    return;
}

require __DIR__ . '/vendor/autoload.php';

use mre\Beacon\Bootstrap;
use mre\Beacon\ConfigLoader;

$aConfig = ConfigLoader::load(__DIR__ . '/config.php');

if(!count($_SERVER) || !count($_GET)) {
  // No payload or invalid request. Bail out.
  return;
}

$oBootstrap = new Bootstrap($aConfig, filter_input_array(INPUT_SERVER), filter_input_array(INPUT_GET));
$oBootstrap->run();
