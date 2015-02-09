<?php

header('HTTP/1.0 204 No Content');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    require_once __DIR__ . '/vendor/autoload.php';
    $beacon = new \mre\Beacon('config.php');
    $beacon->sendMetrics();
}