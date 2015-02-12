<?php

namespace mre\beacon;

/**
 * Class Reader
 * @package mre
 *
 * Reads metrics from a GET URL
 */
class StatsReader
{
    private $oValidator;

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
        if (!$this->checkInput($aData))
        {
            // Invalid input data
            // Can't extract metrics
            return [];
        }

        $_aMetrics = [];

        foreach ($aData as $_sKey => $_sPoint)
        {
            if ($this->oValidator->isValid($_sKey, $_sPoint))
            {
                $_oMetric = $this->createMetric($_sKey, $_sPoint);
                if ($_oMetric)
                {
                    $_aMetrics[] = $_oMetric;
                }
            }
        }
        return $_aMetrics;
    }

    /**
     * Input must be an associative array
     *
     * @param $aData
     * @return bool
     */
    private function checkInput($aData)
    {
        if (!$aData)
        {
            // Invalid. Might be null
            return false;
        }
        return (bool) count(array_filter(array_keys($aData), 'is_string'));
    }

    /**
     * Create a new metric point
     *
     * @param $_sKey string The metric key
     * @param $_sPoint string The metric value with type
     * @return Metric|null
     */
    private function createMetric($_sKey, $_sPoint)
    {
        $_aValueAndType = $this->oValidator->splitValueAndType($_sPoint);

        if (count($_aValueAndType) != 3)
        {
            return null;
        }

        $_iValue = $_aValueAndType[1];
        $_sType = $_aValueAndType[2];

        return new Metric($_sKey, $_iValue, $_sType);
    }
}
