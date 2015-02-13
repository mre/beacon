<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    // Stop if not ajax request
    // to prevent unwanted calls
    return;
}

require_once __DIR__ . '/vendor/autoload.php';

$_aConfig = \mre\Beacon\ConfigLoader::load('config.php');
$_oBeacon = new mre\Beacon\Beacon($_aConfig);
$_oBeacon->run();