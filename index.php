<?php

header('HTTP/1.0 204 No Content');

require_once __DIR__ . '/vendor/autoload.php';

$beacon = new \mre\Beacon('config.php');
$beacon->sendMetrics();
