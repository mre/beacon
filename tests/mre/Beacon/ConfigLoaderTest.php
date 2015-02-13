<?php

namespace mre\Beacon;

class ConfigLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers mre\Beacon\Config::load
     * @covers mre\Beacon\Config::loadPhp
     * @expectedException \mre\Beacon\Exception\UnsupportedFormatException
     * @expectedExceptionMessage PHP file does not return an array
     */
    public function testLoadWithInvalidPhp()
    {
        ConfigLoader::load(__DIR__ . '/mocks/fail/error.php');
    }

    /**
     * @covers mre\Beacon\Config::load
     * @covers mre\Beacon\Config::loadPhp
     * @expectedException \mre\Beacon\Exception\ParseException
     * @expectedExceptionMessage PHP file threw an exception
     */
    public function testLoadWithExceptionalPhp()
    {
        ConfigLoader::load(__DIR__ . '/mocks/fail/error-exception.php');
    }

    /**
     * @covers mre\Beacon\Config::__construct
     * @expectedException \mre\Beacon\Exception\UnsupportedFormatException
     */
    public function testLoadWithUnsupportedFormat()
    {
        ConfigLoader::load(__DIR__ . '/mocks/fail/error.lib');
    }

    /**
     * @covers mre\Beacon\Config::__construct
     * @expectedException \mre\Beacon\Exception\FileNotFoundException
     * @expectedExceptionMessage Configuration file: [ladadeedee] cannot be found
     */
    public function testConstructWithInvalidPath()
    {
        ConfigLoader::load('ladadeedee');
    }

    /**
     * @covers mre\Beacon\Config::__construct
     * @covers mre\Beacon\Config::loadPhp
     */
    public function testConstructWithPhpArray()
    {
        $_aConfig = ConfigLoader::load(__DIR__ . '/mocks/pass/config.php');
        $this->assertEquals('localhost', $_aConfig['host']);
        $this->assertEquals('80', $_aConfig['port']);
    }

    /**
     * @covers mre\Beacon\Config::__construct
     * @covers mre\Beacon\Config::loadPhp
     */
    public function testConstructWithPhpCallable()
    {
        $_aConfig = ConfigLoader::load(__DIR__ . '/mocks/pass/config-exec.php');
        $this->assertEquals('localhost', $_aConfig['host']);
        $this->assertEquals('80', $_aConfig['port']);
    }
}
