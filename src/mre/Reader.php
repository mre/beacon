<?php

namespace mre;

/**
 * Class Reader
 * @package mre
 *
 * Reads metrics from a GET URL
 */
class Reader
{
    public function __construct()
    {
        $this->oValidator = new Validator();
    }

    /**
     * @return \Generator
     */
    public function read($aData)
    {
        foreach ($aData as $_sKey => $_sValue)
        {
            if ($this->oValidator->isValid($_sKey, $_sValue))
            {
                yield new Metric($_sKey,
                    $this->oValidator->extractValue($_sValue),
                    $this->oValidator->extractType($_sValue)
                );
            }
        }
    }
}