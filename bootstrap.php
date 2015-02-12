<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    // Stop if not ajax request
    // to prevent unwanted calls
    return;
}

require_once __DIR__ . '/vendor/autoload.php';

$beacon = new mre\beacon\Beacon('config.php');
$beacon->sendMetrics();