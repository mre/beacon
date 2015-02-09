<?php

namespace mre;

/**
 * Class Reader
 * @package mre
 *
 * Reads metrics from a GET URL
 */
class StatsReader
{
    public function __construct()
    {
        $this->oValidator = new Validator();
    }

    /**
     * @param $aData
     * @return \Generator
     */
    public function read($aData)
    {
        $_aMetrics = [];

        foreach ($aData as $_sKey => $_sPoint)
        {
            if ($this->oValidator->isValid($_sKey, $_sPoint))
            {
                $_aValueAndType = $this->oValidator->splitValueAndType($_sPoint);

                if (count($_aValueAndType) != 3)
                {
                    continue;
                }

                $_iValue = $_aValueAndType[1];
                $_sType = $_aValueAndType[2];

                $_oMetric = new Metric($_sKey, $_iValue, $_sType);
                $_aMetrics[] = $_oMetric;
            }
        }
        return $_aMetrics;
    }
}