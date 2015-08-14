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

    /**
     * @dataProvider namespaceDataProvider
     */
    public function testCorrectNamespace($sUrlPath, $sExpectedApplicationNamespace, $sExpectedFullNamespace)
    {
        $_oBootstrap = new Bootstrap($this->aConfig, ['REQUEST_URI' => $sUrlPath], ['foo' => '123c']);
        $this->assertEquals($sExpectedApplicationNamespace, $_oBootstrap->getApplicationNamespace());
        $this->assertEquals($sExpectedFullNamespace, $_oBootstrap->getFullNamespace());
    }

    public function namespaceDataProvider()
    {
        return array(
            array('/beacon', '', 'rum'),
            array('/beacon/', '', 'rum'),
            array('/beac', 'beac', 'rum.beac'),
            array('/beacon/beacon', 'beacon', 'rum.beacon'),
            array('/beacon/my/app', 'my.app', 'rum.my.app')
        );
    }

    public function testGetSetFullNamespace()
    {
        $_oBootstrap = new Bootstrap($this->aConfig, ['REQUEST_URI' => '/beacon/my/app'], ['foo' => '123c']);
        $_sTestNamespace = 'my.namespace';
        $_oBootstrap->setFullNamespace($_sTestNamespace);
        $this->assertEquals($_sTestNamespace, $_oBootstrap->getFullNamespace());
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
