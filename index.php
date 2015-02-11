<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header('HTTP/1.0 200 OK');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    require_once __DIR__ . '/vendor/autoload.php';
    $beacon = new \mre\Beacon('config.php');
    $beacon->sendMetrics();
}
