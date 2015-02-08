<?php

namespace mre;

/**
 * Class Metric
 * @package mre
 *
 * Wrapper for statsd metrics
 */
class Metric
{
    const TYPE_COUNTER  = 'c';
    const TYPE_TIMING   = 'ms';
    const TYPE_GAUGE    = 'g';
    const TYPE_SET      = 's';

    public $sKey;
    public $iValue;
    public $sType;

    public function __construct($sKey, $iValue, $sType)
    {
        $this->sKey = $sKey;
        $this->iValue = $iValue;
        $this->sType = $sType;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->sKey;
    }

    /**
     * @return integer
     */
    public function getValue()
    {
        return $this->iValue;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->sType;
    }
}