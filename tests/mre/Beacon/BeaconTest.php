<?php

namespace mre\Beacon;

class BeaconTest extends \PHPUnit_Framework_TestCase
{
    /* @var $oBeacon Beacon */
    private $oBeacon;
    private $aConfig;

    protected function setUp()
    {
        $this->aConfig = [
            'statsd' => [
                'namespace' => 'rum',
                'host' => '127.0.0.1',
                'port' => 8125,
                'timeout' => 2 // Connection timeout in seconds
            ]
        ];

        $this->oBeacon = new Beacon($this->aConfig);
    }

    public function testCorrectConfigUsed()
    {
        $this->assertEquals($this->oBeacon->getConfig(), $this->aConfig);
    }

    public function testConfigSetGet()
    {
        $_aConfig = ['foo' => 'bar'];
        $this->oBeacon->setConfig($_aConfig);
        $this->assertEquals($_aConfig, $this->oBeacon->getConfig());
    }
}
