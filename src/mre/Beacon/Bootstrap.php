<?php

namespace mre\Beacon;

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
    private $sFullNamespace;

    /**
     * @var \Auryn\Provider
     */
    private $oInjector;

    /**
     * @var Beacon
     */
    private $oBeacon;

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

        $this->oInjector = new \Auryn\Injector;

        $this->oInjector->define('Domnikl\Statsd\Connection\InetSocket', [
            ':host' => $aConfig['statsd']['host'],
            ':port' => $aConfig['statsd']['port'],
            ':timeout' => $aConfig['statsd']['timeout']
        ]);

        $this->oInjector->define('Domnikl\Statsd\Client', [
            'connection' => 'Domnikl\Statsd\Connection\UdpSocket',
            ':namespace' => $this->getFullNamespace()
        ]);

        $this->oBeacon = $this->oInjector->make('mre\Beacon\Beacon');
    }

    public function run()
    {
        $this->oBeacon->receive($this->aMetricData);
    }

    /**
     * Get the complete metric namespace that goes in front of every
     * key that was sent to the backend
     * @return mixed
     */
    public function getFullNamespace()
    {
        if (!$this->sFullNamespace)
        {
            if (!isset($this->aServerEnv['REQUEST_URI']))
            {
                throw new \InvalidArgumentException('Invalid HTTP request');
            }
            $this->sFullNamespace = $this->aConfig['statsd']['namespace'];

            $_sApplicationNamespace = $this->getApplicationNamespace();

            if ($_sApplicationNamespace)
            {
                $this->sFullNamespace .= '.' . $_sApplicationNamespace;
            }
        }
        return $this->sFullNamespace;
    }

    public function setFullNamespace($sFullNamespace)
    {
        $this->sFullNamespace = $sFullNamespace;
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

    /**
     * Retrieve the application namespace that comes before the normal metric key
     * e.g. if your beacon backend is installed at
     * http://example.com/myvirtualroot/ (with myvirtualroot being the virtualroot dir)
     * and your applications sends metrics to
     * http://example.com/myvirtualroot/my/application
     * your application namespace would be my.application
     */
    public function getApplicationNamespace()
    {
        $_sDirectory = $this->getDirectoryFromUrl();
        $_sApplicationNamespace = str_replace('/', '.', $_sDirectory);

        // Remove virtual root path if it's set in the config
        if (isset($this->aConfig['virtualroot']))
        {
            $_sPrefix = $this->aConfig['virtualroot'];
            if (substr($_sApplicationNamespace, 0, strlen($_sPrefix)) == $_sPrefix) {
                $_sApplicationNamespace = substr($_sApplicationNamespace, strlen($_sPrefix));
            }
        }
        return trim($_sApplicationNamespace, '.');
    }

    private function getDirectoryFromUrl()
    {
        $_sUri = trim($this->aServerEnv['REQUEST_URI'], '/');
        $_aParts = explode("?", $_sUri, 2);
        return $_aParts[0];
    }
}
