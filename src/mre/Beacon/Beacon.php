<?php

namespace mre\Beacon;

use Domnikl\Statsd\Connection\UdpSocket;
use Domnikl\Statsd\Client as Statsd;

class Beacon
{
    private $aConfig;
    private $oReader;

    /**
     * Create  a new beacon instance responsible for retrieving metrics
     * from a client and sending them with statsd.
     *
     * @param array $aConfig Config settings
     */
    public function __construct(array $aConfig)
    {
        $this->aConfig = $aConfig;
        $this->oReader = new MetricReader();

        $_oStatsdClient = $this->initStatsd();
        $this->oSender = new MetricSender($_oStatsdClient);
    }

    /**
     * @return array Current config
     */
    public function getConfig()
    {
        return $this->aConfig;
    }

    /**
     * @param array $aConfig New config
     */
    public function setConfig($aConfig)
    {
        $this->aConfig = $aConfig;
    }

    /**
     * Initialize statsd instance
     */
    private function initStatsd()
    {
        $_oConnection = new UdpSocket(
            $this->aConfig['statsd']['host'],
            $this->aConfig['statsd']['port'],
            $this->aConfig['statsd']['timeout'],
            false // no persistent connection
        );
        $_sNamespace = $this->aConfig['statsd']['namespace'];
        return new Statsd($_oConnection, $_sNamespace);
    }

    /**
     * Get and send metrics from client
     */
    public function run()
    {
        $_aMetrics = $this->oReader->read(filter_input_array(INPUT_GET));
        $this->oSender->send($_aMetrics);
    }
}
