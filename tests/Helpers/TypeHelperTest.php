<?php

namespace LaravelRocket\Foundation\Tests\Helpers;

use LaravelRocket\Foundation\Tests\TestCase;

class TypeHelperTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var \LaravelRocket\Foundation\Helpers\TypeHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\TypeHelperInterface::class);
        $this->assertNotNull($helper);
    }
}
