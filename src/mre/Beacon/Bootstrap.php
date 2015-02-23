<?php

namespace mre\Beacon;

use Auryn\Provider;

class Bootstrap
{
    /**
     * @var array
     */
    private $aConfig;

    /**
     * @var array
     */
    private $aServerEnv;

    /**
     * @var array
     */
    private $aMetricData;

    /**
     * @var string
     */
    private $sNamespace;

    /**
     * @param array $aConfig
     * @param array $aServerEnv
     * @param array $aMetricData
     */
    public function __construct(array $aConfig, array $aServerEnv, array $aMetricData)
    {
        $this->aConfig = $aConfig;
        $this->aServerEnv = $aServerEnv;
        $this->aMetricData = $aMetricData;

        $this->oInjector = new Provider;

        $this->oInjector->define('Domnikl\Statsd\Connection\InetSocket', [
            ':host' => $aConfig['statsd']['host'],
            ':port' => $aConfig['statsd']['port'],
            ':timeout' => $aConfig['statsd']['timeout']
        ]);

        $this->oInjector->define('Domnikl\Statsd\Client', [
            'connection' => 'Domnikl\Statsd\Connection\UdpSocket',
            ':namespace' => $this->getNamespace($aServerEnv)
        ]);

        $this->oBeacon = $this->oInjector->make('mre\Beacon\Beacon');
    }

    public function run()
    {
        $this->oBeacon->receive($this->aMetricData);
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        if (!$this->sNamespace)
        {
            if (!array_key_exists('REQUEST_URI', $this->aServerEnv))
            {
                throw new \InvalidArgumentException('Invalid HTTP request');
            }

            $_sGlobalPrefix = $this->getGlobalPrefix();

            $this->sNamespace = $this->aConfig['statsd']['namespace'] . '.' . $_sGlobalPrefix;
        }
        return $this->sNamespace;
    }

    public function setNamespace($sNamespace)
    {
        $this->sNamespace = $sNamespace;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->aConfig;
    }

    /**
     * @param array $aConfig
     */
    public function setConfig($aConfig)
    {
        $this->aConfig = $aConfig;
    }

    /**
     * @return array
     */
    public function getServerEnv()
    {
        return $this->aServerEnv;
    }

    /**
     * @param array $aServerEnv
     */
    public function setServerEnv($aServerEnv)
    {
        $this->aServerEnv = $aServerEnv;
    }

    /**
     * @return array
     */
    public function getMetricData()
    {
        return $this->aMetricData;
    }

    /**
     * @param array $aMetricData
     */
    public function setMetricData($aMetricData)
    {
        $this->aMetricData = $aMetricData;
    }

    private function getGlobalPrefix()
    {
        $_sApplicationNamespace = $this->getApplicationNamespace();

        // Remove virtual root path if it's set in the config
        if (array_key_exists('virtualroot', $this->aConfig))
        {
            $_sPrefix = $this->aConfig['virtualroot'] . '.';
            if (substr($_sApplicationNamespace, 0, strlen($_sPrefix)) == $_sPrefix) {
                $_sApplicationNamespace = substr($_sApplicationNamespace, strlen($_sPrefix));
            }
        }
        return $_sApplicationNamespace;
    }

    private function getApplicationNamespace()
    {
        $_sUri = trim($this->aServerEnv['REQUEST_URI'], '/');
        $_aParts = explode("?", $_sUri, 2);

        $_sApplicationNamespace = str_replace('/', '.', $_aParts[0]);

        return trim($_sApplicationNamespace, '.');
    }
}
