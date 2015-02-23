<?php

namespace mre\Beacon;


class BootstrapTest extends \PHPUnit_Framework_TestCase
{
    private $aConfig;

    protected function setUp()
    {
        $this->aConfig = ConfigLoader::load(__DIR__ . '/fixtures/Bootstrap/config_valid.php');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid HTTP request
     */
    public function testIncorrectBootstrap()
    {
        new Bootstrap($this->aConfig, [], ['foo' => '123c']);
    }

    public function testCorrectNamespace()
    {
        $_oBootstrap = new Bootstrap($this->aConfig, ['REQUEST_URI' => '/beacon/my/app'], ['foo' => '123c']);
        $_sExpectedNamespace = $this->aConfig['statsd']['namespace'] . '.my.app';
        $this->assertEquals($_sExpectedNamespace, $_oBootstrap->getNamespace());
    }
}
