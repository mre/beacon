<?php

namespace mre\Beacon;

use Prophecy\Argument;
use Prophecy\Prophet;

class BeaconTest extends \PHPUnit_Framework_TestCase
{
    /* @var $oBeacon Beacon */
    private $oBeacon;
    private $oMetricReader;
    private $oMetricSender;

    protected function setUp()
    {
        $oProphet = new Prophet();
        $this->oMetricReader = new MetricReader(new Validator());
        $this->oMetricSender = $oProphet->prophesize('mre\Beacon\MetricSender');

        $this->oBeacon = new Beacon($this->oMetricReader, $this->oMetricSender->reveal());
    }

    public function testSendInput()
    {
        $_aValidKeys = ['foo' => '123c', 'bar' => '33ms', 'baz.boo' => '10s'];
        $_aInvalidKeys = ['.' => '100c', 'bla' => '', 'bean' => 12];
        $_aRawData = array_merge($_aValidKeys, $_aInvalidKeys);

        $this->oBeacon->run($_aRawData);

        $_aValidMetrics = [
            new Metric('foo', '123', 'c'),
            new Metric('bar', '33', 'ms'),
            new Metric('baz.boo', '10', 's'),
        ];
        $this->oMetricSender->send($_aValidMetrics)->shouldHaveBeenCalled();
    }
}
