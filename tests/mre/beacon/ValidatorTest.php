<?php

namespace mre\beacon;


use PHPUnit_Framework_TestCase;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    /* @var $oValidator Validator */
    private $oValidator;

    protected function setUp()
    {
        $this->oValidator = new Validator();
    }

    /**
     * @dataProvider keyProvider
     * @param $sKey
     * @param $bExpected
     */
    public function testValidKey($sKey, $bExpected)
    {
        $this->assertEquals($bExpected, $this->oValidator->isValidKey($sKey));
    }

    /**
     * @dataProvider valueProvider
     * @param $mValue
     * @param $bExpected
     */
    public function testValidValue($mValue, $bExpected)
    {
        $this->assertEquals($bExpected, $this->oValidator->isValidValue($mValue));
    }

    /**
     * @dataProvider typeProvider
     * @param $sType
     * @param $bExpected
     */
    public function testValidType($sType, $bExpected)
    {
        $this->assertEquals($bExpected, $this->oValidator->isValidType($sType));
    }

    /**
     * @dataProvider MeasurementPointProvider
     * @param $sPoint
     * @param $bExpected
     */
    public function testValidValueWithType($sPoint, $bExpected)
    {
        $this->assertEquals($bExpected, $this->oValidator->isValidMeasurementPoint($sPoint));
    }
    
    public function keyProvider()
    {
        return [
            ['foo', true],
            ['FOO', true],
            ['FOO_BAR', true],
            ['FOO.BAR', true],
            ['FOO.bar', true],
            ['foo.BAR', true],
            ['test.test.test', true],
            ['test.test_test', true],
            ['test_test', true],
            ['test_test_test', true],
            [null, false],
            ['', false],
            ['123', false],
            [123, false],
            ['FOO:BAR', false],
            ['..', false],
            ['ಠ_ಠ', false],
            ['.test', false],
            ['.test1', false],
            ['test.test.', false],
            ['test..test.', false],
            ['test.test..test..test', false],
            ['.test.test', false],
            ['test.test_', false]
        ];
    }

    public function typeProvider()
    {
        return [
            ['c', true],
            ['g', true],
            ['ms', true],
            ['s', true],
            ['v', false],
            ['bla', false],
            ['', false],
            [null, false],
            [-1, false],
            [1.0, false]
        ];
    }

    public function valueProvider()
    {
        return [
            [123, true],
            [-123, true],
            [1.0, true],
            [-1.0, true],
            ['123', true],
            [null, false],
            ['', false],
            ['abc', false]
        ];
    }

    public function MeasurementPointProvider()
    {
        return [
            ['100ms', true],
            ['1c', true],
            ['-1c', true],
            ['12g', true],
            ['12s', true],
            ['1.24g', true],
            ['-1.24g', true],
            ['c-1', false],
            ['1cg', false],
            ['1z', false]
        ];
    }
}
