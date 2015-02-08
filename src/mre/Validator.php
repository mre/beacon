<?php

namespace mre;


class Validator
{
    /**
     * Validate a statsd key-value pair
     *
     * @param string $sKey Metric key
     * @param string $sPoint StatsD measurement point (e.g. 100ms or 1c)
     * @return bool
     */
    public function isValid($sKey, $sPoint)
    {
        return $this->isValidKey($sKey) && $this->isValidMeasurementPoint($sPoint);
    }

    /**
     * A valid measurement points consists of a
     * valid value and a valid type
     *
     * @param $sKey string Key to check
     * @return bool Is valid key
     */
    public function isValidMeasurementPoint($sPoint)
    {
        $_aValueAndType = $this->splitValueAndType($sPoint);

        if (count($_aValueAndType) != 3)
        {
            return False;
        }

        $_iValue = $_aValueAndType[1];
        $_sType = $_aValueAndType[2];

        return $this->isValidValue($_iValue) && $this->isValidType($_sType);
    }

    /**
     * Split the measurement point into numeric value and metric type
     * @param string $sPoint Value with type (e.g. 100ms)
     * @return array $_aMatches Matches found
     */
    public function splitValueAndType($sPoint)
    {
        preg_match('/^(-?\d*\.?\d+)([a-z]+)$/', $sPoint, $_aMatches);
        return $_aMatches;
    }

    /**
     * A valid key only consists of uppercase and
     * lowercase alphabetic words as well as
     * dots and underscores in between
     *
     * @param $sKey string Key to check
     * @return bool Is valid key
     */
    public function isValidKey($sKey)
    {
        return !empty($sKey) && preg_match('/^[a-zA-Z]+(?:[._][a-zA-Z]+)*$/', $sKey) == 1;
    }

    /**
     * Values can be normal floats e.g. 3.14, shorthands for decimal
     * part only e.g. .5 and integers e.g. 9 as well as negative numbers.
     *
     * @param string $sValue Value to check
     * @return bool Is valid value
     */
    public function isValidValue($sValue)
    {
        return preg_match('/^(-?\d*\.?\d+)$/', $sValue) == 1;
    }

    /**
     * Type must be one of the types defined in Metric class
     *
     * @param string $sType Type to check
     * @return bool
     */
    public function isValidType($sType)
    {
        if (!$sType)
        {
            return False;
        }

        switch ($sType)
        {
            case Metric::TYPE_COUNTER:
            case Metric::TYPE_GAUGE:
            case Metric::TYPE_SET:
            case Metric::TYPE_TIMING:
                return True;
        }
        // Invalid type
        return False;
    }
}