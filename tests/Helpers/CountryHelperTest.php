<?php
namespace LaravelRocket\Foundation\Tests\Helpers;

use LaravelRocket\Foundation\Tests\TestCase;

class CountryHelperTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var \LaravelRocket\Foundation\Helpers\CountryHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\CountryHelperInterface::class);
        $this->assertNotNull($helper);
    }
}
