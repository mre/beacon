<?php

namespace mre\Beacon;

class Beacon
{
    private $oReader;
    private $oSender;

    /**
     * Create  a new beacon instance responsible for retrieving metrics
     * from a client and sending them with statsd.
     *
     * @param array $aConfig Config settings
     * @param MetricReader $oReader
     * @param MetricSender $oSender
     */
    public function __construct(MetricReader $oReader, MetricSender $oSender)
    {
        $this->oReader = $oReader;
        $this->oSender = $oSender;
    }

    /**
     * Get and send metrics from client
     */
    public function run($aRawData)
    {
        $_aMetrics = $this->oReader->read($aRawData);
        $this->oSender->send($_aMetrics);
    }
}
