<?php

namespace mre\Beacon;

use Auryn\Provider;

class Bootstrap
{
    public static function run($aConfig, $sAppNamespace)
    {
        $_sFullNamespace = $aConfig['statsd']['namespace'] . '.' . $sAppNamespace;

        $oInjector = new Provider;

        $oInjector->define('Domnikl\Statsd\Connection\InetSocket', [
            ':host' => $aConfig['statsd']['host'],
            ':port' => $aConfig['statsd']['port'],
            ':timeout' => $aConfig['statsd']['timeout']
        ]);

        $oInjector->define('Domnikl\Statsd\Client', [
            'connection' => 'Domnikl\Statsd\Connection\UdpSocket',
            ':namespace' => $_sFullNamespace
        ]);

        $_oBeacon = $oInjector->make('mre\Beacon\Beacon');
        $_oBeacon->receive(filter_input_array(INPUT_GET));
    }
}