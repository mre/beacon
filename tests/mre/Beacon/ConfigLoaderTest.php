<?php

namespace mre\Beacon;

class ConfigLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \mre\Beacon\Exception\UnsupportedFormatException
     * @expectedExceptionMessage PHP file does not return an array
     */
    public function testLoadWithInvalidPhp()
    {
        ConfigLoader::load(__DIR__ . '/fixtures/ConfigLoader/fail/error.php');
    }

    /**
     * @expectedException \mre\Beacon\Exception\ParseException
     * @expectedExceptionMessage PHP file threw an exception
     */
    public function testLoadWithExceptionalPhp()
    {
        ConfigLoader::load(__DIR__ . '/fixtures/ConfigLoader/fail/error-exception.php');
    }

    /**
     * @expectedException \mre\Beacon\Exception\UnsupportedFormatException
     */
    public function testLoadWithUnsupportedFormat()
    {
        ConfigLoader::load(__DIR__ . '/fixtures/ConfigLoader/fail/error.foo');
    }

    /**
     * @expectedException \mre\Beacon\Exception\FileNotFoundException
     * @expectedExceptionMessage Configuration file: [ladadee] cannot be found
     */
    public function testInvalidPath()
    {
        ConfigLoader::load('ladadee');
    }

    public function testLoadPhpArray()
    {
        $_aConfig = ConfigLoader::load(__DIR__ . '/fixtures/ConfigLoader/pass/config.php');
        $this->assertEquals('localhost', $_aConfig['host']);
        $this->assertEquals('80', $_aConfig['port']);
    }

    public function testLoadPhpCallable()
    {
        $_aConfig = ConfigLoader::load(__DIR__ . '/fixtures/ConfigLoader/pass/config-exec.php');
        $this->assertEquals('localhost', $_aConfig['host']);
        $this->assertEquals('80', $_aConfig['port']);
    }
}
