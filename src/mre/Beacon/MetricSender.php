<?php

namespace mre\Beacon;

use Domnikl\Statsd\Client;

class MetricSender
{
    private $oStatsdClient;

    /**
     * @param Client $oStatsdClient
     * @param array $aAllowedMetrics
     */
    public function __construct(Client $oStatsdClient, array $aAllowedMetrics = [])
    {
        $this->oStatsdClient = $oStatsdClient;
        $this->aAllowedMetrics = $aAllowedMetrics;
    }

    /**
     * @param Metric[] $aMetrics
     */
    public function sendAll(array $aMetrics)
    {
        foreach ($aMetrics as $_oMetric)
        {
            if (empty($this->aAllowedMetrics) || array_key_exists($_oMetric->getKey(), $this->aAllowedMetrics))
            {
                $this->send($_oMetric);
            }
        }
    }

    private function send(Metric $oMetric)
    {
        switch ($oMetric->getType())
        {
            case Metric::TYPE_COUNTER:
                $this->oStatsdClient->count($oMetric->getKey(), $oMetric->getValue());
                break;
            case Metric::TYPE_TIMING:
                $this->oStatsdClient->timing($oMetric->getKey(), $oMetric->getValue());
                break;
            case Metric::TYPE_SET:
                $this->oStatsdClient->set($oMetric->getKey(), $oMetric->getValue());
                break;
            case Metric::TYPE_GAUGE:
                $this->oStatsdClient->gauge($oMetric->getKey(), $oMetric->getValue());
                break;
        }
    }
}