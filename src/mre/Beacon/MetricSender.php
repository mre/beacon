<?php

namespace mre\Beacon;

use Domnikl\Statsd\Client;

class MetricSender
{
    private $oStatsdClient;

    /**
     * @param Client $oStatsdClient
     */
    public function __construct(Client $oStatsdClient)
    {
        $this->oStatsdClient = $oStatsdClient;
    }

    /**
     * @param Metric[] $aMetrics
     */
    public function send(array $aMetrics)
    {
        foreach ($aMetrics as $_oMetric)
        {
            switch ($_oMetric->getType())
            {
                case Metric::TYPE_COUNTER:
                    $this->oStatsdClient->count($_oMetric->getKey(), $_oMetric->getValue());
                    break;
                case Metric::TYPE_TIMING:
                    $this->oStatsdClient->timing($_oMetric->getKey(), $_oMetric->getValue());
                    break;
                case Metric::TYPE_SET:
                    $this->oStatsdClient->set($_oMetric->getKey(), $_oMetric->getValue());
                    break;
                case Metric::TYPE_GAUGE:
                    $this->oStatsdClient->gauge($_oMetric->getKey(), $_oMetric->getValue());
                    break;
            }
        }
    }
}