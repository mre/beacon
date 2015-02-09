<?php

namespace mre;

use Domnikl\Statsd\Connection\UdpSocket;
use Noodlehaus\Config as Config;
use Domnikl\Statsd\Client as Statsd;

class Beacon
{
    private $oReader;
    private $oStatsd;
    private $oConfig;

    /**
     * Create  a new beacon instance responsible for retrieving metrics
     * from a client and sending them with statsd.
     *
     * @param $sConfigFile
     * @param bool $analyze
     */
    public function __construct($sConfigFile)
    {
        $this->oConfig = Config::load($sConfigFile);
        $this->oReader = new StatsReader();

        $this->initStatsd();
    }

    /**
     * Initialize statsd instance
     */
    private function initStatsd()
    {
        $_oConnection = new UdpSocket(
            $this->oConfig->get('statsd')['host'],
            $this->oConfig->get('statsd')['port'],
            $this->oConfig->get('statsd')['timeout'],
            false // no persistent connection
        );
        $_sNamespace = $this->oConfig->get('statsd')['namespace'];
        $this->oStatsd = new Statsd($_oConnection, $_sNamespace);
    }

    /**
     * Get metrics from client
     */
    public function sendMetrics()
    {
        foreach ($this->oReader->read($_GET) as $_oMetric)
        {
            $this->oStatsd->send($_oMetric->getKey(), $_oMetric->getValue(), $this->_oMetric->getType(), 1);
        }
    }
}
