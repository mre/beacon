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

    public function testGetSetNamespace()
    {
        $_oBootstrap = new Bootstrap($this->aConfig, ['REQUEST_URI' => '/beacon/my/app'], ['foo' => '123c']);
        $_sTestNamespace = 'my.namespace';
        $_oBootstrap->setNamespace($_sTestNamespace);
        $this->assertEquals($_sTestNamespace, $_oBootstrap->getNamespace());
    }

    public function testGetSetConfig()
    {
        $_oBootstrap = new Bootstrap($this->aConfig, ['REQUEST_URI' => '/beacon/my/app'], ['foo' => '123c']);
        $_aConfig = [];
        $_oBootstrap->setConfig($_aConfig);
        $this->assertEquals($_aConfig, $_oBootstrap->getConfig());
    }

    public function testGetSetServerEnv()
    {
        $_oBootstrap = new Bootstrap($this->aConfig, ['REQUEST_URI' => '/beacon/my/app'], ['foo' => '123c']);
        $_aServerEnv= [];
        $_oBootstrap->setServerEnv($_aServerEnv);
        $this->assertEquals($_aServerEnv, $_oBootstrap->getServerEnv());
    }

    public function testGetSetMetricData()
    {
        $_oBootstrap = new Bootstrap($this->aConfig, ['REQUEST_URI' => '/beacon/my/app'], ['foo' => '123c']);
        $_aMetricData = [];
        $_oBootstrap->setMetricData($_aMetricData);
        $this->assertEquals($_aMetricData, $_oBootstrap->getMetricData());
    }
}
