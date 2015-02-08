<?php

namespace mre;


use PHPUnit_Framework_TestCase;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    private $oValidator;

    protected function setUp()
    {
        $this->oValidator = new Validator();
    }

    /**
     * @dataProvider keyProvider
     */
    public function testValidKey($sKey, $bExpected)
    {
        $this->assertEquals($bExpected, $this->oValidator->isValidKey($sKey));
    }

    /**
     * @dataProvider valueProvider
     */
    public function testValidValue($mValue, $bExpected)
    {
        $this->assertEquals($bExpected, $this->oValidator->isValidValue($mValue));
    }

    /**
     * @dataProvider typeProvider
     */
    public function testValidType($sType, $bExpected)
    {
        $this->assertEquals($bExpected, $this->oValidator->isValidType($sType));
    }

    /**
     * @dataProvider MeasurementPointProvider
     */
    public function testValidValueWithType($sPoint, $bExpected)
    {
        $this->assertEquals($bExpected, $this->oValidator->isValidMeasurementPoint($sPoint));
    }
    
    public function keyProvider()
    {
        return [
            ['foo', True],
            ['FOO', True],
            ['FOO_BAR', True],
            ['FOO.BAR', True],
            ['FOO.bar', True],
            ['foo.BAR', True],
            ['test.test.test', True],
            ['test.test_test', True],
            ['test_test', True],
            ['test_test_test', True],
            [null, False],
            ['', False],
            ['123', False],
            [123, False],
            ['FOO:BAR', False],
            ['..', False],
            ['ಠ_ಠ', False],
            ['.test', False],
            ['.test1', False],
            ['test.test.', False],
            ['test..test.', False],
            ['test.test..test..test', False],
            ['.test.test', False],
            ['test.test_', False]
        ];
    }

    public function typeProvider()
    {
        return [
            ['c', True],
            ['g', True],
            ['ms', True],
            ['s', True],
            ['v', False],
            ['bla', False]
        ];
    }

    public function valueProvider()
    {
        return [
            [123, True],
            [-123, True],
            [1.0, True],
            [-1.0, True],
            ['123', True],
            [null, False],
            ['', False],
            ['abc', False]
        ];
    }

    public function MeasurementPointProvider()
    {
        return [
            ['100ms', True],
            ['1c', True],
            ['-1c', True],
            ['12g', True],
            ['12s', True],
            ['1.24g', True],
            ['-1.24g', True],
            ['c-1', False],
            ['1cg', False],
            ['1z', False]
        ];
    }
}
