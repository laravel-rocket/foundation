<?php
namespace LaravelRocket\Foundation\Tests\Helpers;

use LaravelRocket\Foundation\Tests\TestCase;

class DataHelperTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var \LaravelRocket\Foundation\Helpers\DataHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\DataHelperInterface::class);
        $this->assertNotNull($helper);
    }

    public function testGetCountryName()
    {
        /** @var \LaravelRocket\Foundation\Helpers\DataHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\DataHelperInterface::class);

        $result = $helper->getCountryName('JPN', 'TEST');
        $this->assertEquals('TEST', $result);
    }

    public function testGetCurrencyName()
    {
        /** @var \LaravelRocket\Foundation\Helpers\DataHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\DataHelperInterface::class);

        $result = $helper->getCurrencyName('JPY', 'TEST');
        $this->assertEquals('TEST', $result);
    }

}
