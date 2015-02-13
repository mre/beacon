<?php

namespace mre\Beacon;

use mre\Beacon\Exception\ParseException;
use mre\Beacon\Exception\UnsupportedFormatException;

class ConfigLoader
{
    /**
     * Loads a PHP file and gets its contents as an array
     *
     * @param string $sConfigFilePath Config file
     *
     * @return array
     *
     * @throws ParseException If the PHP file throws an exception
     * @throws UnsupportedFormatException If the PHP file does not return an array
     */
    public static function load($sConfigFilePath)
    {
        // Require the file
        // If it throws an exception, rethrow it
        try
        {
            $_oTemp = require $sConfigFilePath;
        }
        catch (\Exception $oException)
        {
            throw new ParseException(
                array(
                    'message'   => 'PHP file threw an exception',
                    'exception' => $oException
                )
            );
        }
        // If we have a callable, run it and expect an array back
        if (is_callable($_oTemp))
        {
            $_oTemp = call_user_func($_oTemp);
        }

        // Check for array
        // If its anything else, throw an exception
        if (!$_oTemp || !is_array($_oTemp))
        {
            throw new UnsupportedFormatException('PHP file does not return an array');
        }
        return $_oTemp;
    }
}