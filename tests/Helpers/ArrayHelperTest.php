<?php

namespace LaravelRocket\Foundation\Tests\Helpers;

use LaravelRocket\Foundation\Tests\TestCase;

class ArrayHelperTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var \LaravelRocket\Foundation\Helpers\ArrayHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\ArrayHelperInterface::class);
        $this->assertNotNull($helper);
    }

    public function testPopWithKey()
    {
        /** @var \LaravelRocket\Foundation\Helpers\ArrayHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\ArrayHelperInterface::class);

        $testArray = [
            'ABC' => 'DEF',
            'GHI' => 'MNO',
        ];

        $result = $helper->popWithKey('ABC', $testArray);

        $this->assertEquals('DEF', $result);
        $this->assertEquals(1, count($testArray));

        $result = $helper->popWithKey('ABC', $testArray, 'NONE');

        $this->assertEquals('NONE', $result);
        $this->assertEquals(1, count($testArray));
    }

    public function testFilterElements()
    {
        /** @var \LaravelRocket\Foundation\Helpers\ArrayHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\ArrayHelperInterface::class);

        $testArray = [
            'ABC' => 'DEF',
            'GHI' => 'MNO',
            'XXX' => null,
        ];

        $result = $helper->filterElements($testArray, ['ABC', 'XXX'], false);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('ABC', $result);
        $this->assertArrayHasKey('XXX', $result);
        $this->assertArrayNotHasKey('GHI', $result);

        $result = $helper->filterElements($testArray, ['ABC', 'XXX'], true);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('ABC', $result);
        $this->assertArrayNotHasKey('XXX', $result);
        $this->assertArrayNotHasKey('GHI', $result);
    }
}
