<?php

namespace mre\Beacon;

use PHPUnit_Framework_TestCase;

class MetricTest extends PHPUnit_Framework_TestCase
{
    public function testValidMetric()
    {
        $_oMetric = new Metric('foo', 123, 'c');
        $this->assertEquals('foo', $_oMetric->getKey());
        $this->assertEquals(123, $_oMetric->getValue());
        $this->assertEquals('c', $_oMetric->getType());
    }
}
