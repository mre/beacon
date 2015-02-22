<?php

namespace mre\Beacon;

use Auryn\Provider;

class Bootstrap
{
    public static function run($aConfig)
    {
        $oInjector = new Provider;

        $oInjector->define('Domnikl\Statsd\Connection\InetSocket', [
            ':host' => $aConfig['statsd']['host'],
            ':port' => $aConfig['statsd']['port'],
            ':timeout' => $aConfig['statsd']['timeout']
        ]);

        $_sAppNamespace = self::getNamespace();
        $_sFullNamespace = $aConfig['statsd']['namespace'] . '.' . $_sAppNamespace;

        $oInjector->define('Domnikl\Statsd\Client', [
            'connection' => 'Domnikl\Statsd\Connection\UdpSocket',
            ':namespace' => $_sFullNamespace
        ]);

        $_oBeacon = $oInjector->make('mre\Beacon\Beacon');
        $_oBeacon->receive(filter_input_array(INPUT_GET));
    }

    private static function getNamespace()
    {
        $_sUri = $_SERVER['REQUEST_URI'];
        $_aParts = explode("?", $_sUri, 2);
        return $_aParts[0];
    }
}