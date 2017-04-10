<?php
namespace LaravelRocket\Foundation\Tests\Helpers;

use LaravelRocket\Foundation\Tests\TestCase;

class StringHelperTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var \LaravelRocket\Foundation\Helpers\StringHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\StringHelperInterface::class);
        $this->assertNotNull($helper);
    }

    public function testRandomString()
    {
        /** @var \LaravelRocket\Foundation\Helpers\StringHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\StringHelperInterface::class);
        $string = $helper->randomString(10);
        $this->assertEquals(10, strlen($string));

        $anotherString = $helper->randomString(10);
        $this->assertNotEquals($anotherString, $string);
    }
}
