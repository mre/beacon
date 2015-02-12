<?php

header('HTTP/1.0 200 OK');
header('Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: {now} GMT');

use mre\beacon\Beacon;

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    require_once __DIR__ . '/vendor/autoload.php';
    $beacon = new Beacon('config.php');
    $beacon->sendMetrics();
}
