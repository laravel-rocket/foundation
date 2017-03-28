<?php

namespace LaravelRocket\Foundation\Tests\Helpers;

use LaravelRocket\Foundation\Tests\TestCase;

class CollectionHelperTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var  \LaravelRocket\Foundation\Helpers\CollectionHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\CollectionHelperInterface::class);
        $this->assertNotNull($helper);
    }
}
