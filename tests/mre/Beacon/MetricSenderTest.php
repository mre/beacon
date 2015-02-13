<?php

namespace mre\Beacon;

use Prophecy\Prophet;

class MetricSenderTest extends \PHPUnit_Framework_TestCase
{
    private $oStatsdClientMock;

    /** @var MetricSender $oMetricSender */
    private $oMetricSender;

    public function setUp()
    {
        $oProphet = new Prophet();
        $this->oStatsdClientMock = $oProphet->prophesize('Domnikl\Statsd\Client');

        $this->oMetricSender = new MetricSender($this->oStatsdClientMock->reveal());
    }

    public function testSendMetrics()
    {
        $_oMetric = new Metric('foo', '123', Metric::TYPE_COUNTER);

        $this->oMetricSender->send([$_oMetric]);

        $this->oStatsdClientMock->count('foo', '123')->shouldHaveBeenCalled();
    }
}
