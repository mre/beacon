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
     * @param MetricReader $oReader Metric reader object
     * @param MetricSender $oSender Metric sender object
     */
    public function __construct(MetricReader $oReader, MetricSender $oSender)
    {
        $this->oReader = $oReader;
        $this->oSender = $oSender;
    }

    /**
     * Get and send metrics from client
     * @param array $aRawData The raw data to analyze (usually the GET request data
     */
    public function receive($aRawData)
    {
        $_aMetrics = $this->oReader->read($aRawData);
        $this->oSender->sendAll($_aMetrics);
    }
}
