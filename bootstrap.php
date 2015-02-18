<?php

namespace mre\Beacon;
/*
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    // Stop if not ajax request
    // to prevent unwanted calls
    return;
}
*/
use Auryn\Provider;

require_once __DIR__ . '/vendor/autoload.php';

$aConfig = ConfigLoader::load('config.php');

$oInjector = new Provider;

$oInjector->define('Domnikl\Statsd\Connection\InetSocket', [
    ':host' => $aConfig['statsd']['host'],
    ':port' => $aConfig['statsd']['port'],
    ':timeout' => $aConfig['statsd']['timeout']
]);

$oInjector->define('Domnikl\Statsd\Client', [
    'connection' => 'Domnikl\Statsd\Connection\UdpSocket',
    ':namespace' => $aConfig['statsd']['namespace']
]);

$_oBeacon = $oInjector->make('mre\Beacon\Beacon');
$_oBeacon->run(filter_input_array(INPUT_GET));
