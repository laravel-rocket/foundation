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
}
