<?php

namespace mre\beacon;

use PHPUnit_Framework_TestCase;

class StatsReaderTest extends PHPUnit_Framework_TestCase
{
    /* @var $oReader StatsReader */
    private $oReader;

    protected function setUp()
    {
        $this->oReader = new StatsReader();
    }

    public function testReaderReturnsAllCorrectMetrics()
    {
        $_aRawData = [
            'foo' => '123g',
            'bar' => '-1.9c',
            '123' => '100c',
            'blub' => '1.33g',
            'zoo' => 123,
            'maa' => '32v'
        ];

        /** @var Metric[] $_aMetrics */
        $_aMetrics = $this->oReader->read($_aRawData);

        $this->assertEquals(3, count($_aMetrics));
        $this->assertEquals('foo', $_aMetrics[0]->getKey());
        $this->assertEquals('123', $_aMetrics[0]->getValue());
        $this->assertEquals('g', $_aMetrics[0]->getType());

        $this->assertEquals('bar', $_aMetrics[1]->getKey());
        $this->assertEquals('-1.9', $_aMetrics[1]->getValue());
        $this->assertEquals('c', $_aMetrics[1]->getType());

        $this->assertEquals('blub', $_aMetrics[2]->getKey());
        $this->assertEquals('1.33', $_aMetrics[2]->getValue());
        $this->assertEquals('g', $_aMetrics[2]->getType());
    }

    public function testEmptyInputReturnsNoMetrics()
    {
        $this->assertEquals([], $this->oReader->read([]));
    }

    public function testNullInputReturnsNoMetrics()
    {
        $this->assertEquals([], $this->oReader->read(null));
    }

    public function testInvalidInputReturnsNoMetrics()
    {
        $this->assertEquals([], $this->oReader->read('bla'));
    }
}
