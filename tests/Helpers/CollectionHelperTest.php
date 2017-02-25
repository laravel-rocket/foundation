<?php

namespace Tests\Helpers;

use Tests\TestCase;

class CollectionHelperTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \LaravelRocket\Foundation\Helpers\CollectionHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\CollectionHelperInterface::class);
        $this->assertNotNull($helper);
    }
}
