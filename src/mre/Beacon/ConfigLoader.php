<?php

namespace mre\Beacon;

use mre\Beacon\Exception\FileNotFoundException;
use mre\Beacon\Exception\ParseException;
use mre\Beacon\Exception\UnsupportedFormatException;

class ConfigLoader
{
    /**
     * Loads a PHP file and gets its contents as an array
     *
     * @param  $sConfigFilePath string
     * @return mixed
     * @throws FileNotFoundException
     * @throws ParseException
     * @throws UnsupportedFormatException
     */
    public static function load($sConfigFilePath)
    {
        self::checkValidFormat($sConfigFilePath);

        $_oTemp = self::tryLoad($sConfigFilePath);
        return self::parse($_oTemp);
    }

    /**
     * If possible, read file contents
     *
     * @param $sConfigFilePath
     * @return mixed
     * @throws FileNotFoundException
     * @throws ParseException
     */
    private static function tryLoad($sConfigFilePath)
    {
        // Require the file
        // If it throws an exception, rethrow it
        try
        {
            $oTemp = require $sConfigFilePath;
            return $oTemp;
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
    }

    private static function parse($oTemp)
    {
        // If we have a callable, run it and expect an array back
        if (is_callable($oTemp))
        {
            $oTemp = call_user_func($oTemp);
        }

        // Check for array
        // If it's anything else, throw an exception
        if (!$oTemp || !is_array($oTemp))
        {
            throw new UnsupportedFormatException('PHP file does not return an array');
        }
        return $oTemp;
    }

    /**
     * Check if config file format is correct
     *
     * @param $sConfigFilePath
     * @throws FileNotFoundException
     * @throws UnsupportedFormatException
     */
    private static function checkValidFormat($sConfigFilePath)
    {
        // Get file information
        $_aInfo = pathinfo($sConfigFilePath);

        // Check if config file exists or throw an exception
        if (!file_exists($sConfigFilePath))
        {
            throw new FileNotFoundException("Configuration file: [$sConfigFilePath] cannot be found");
        }

        if ($_aInfo['extension'] !== 'php')
        {
            throw new UnsupportedFormatException('Unsupported configuration format. Must be PHP file');
        }
    }
}
