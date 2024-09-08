<?php

namespace LaravelRocket\Foundation\Tests\Helpers;

use LaravelRocket\Foundation\Tests\TestCase;

class PaginationHelperTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var \LaravelRocket\Foundation\Helpers\PaginationHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\PaginationHelperInterface::class);
        $this->assertNotNull($helper);
    }

    public function testRenderPager()
    {
        /** @var \LaravelRocket\Foundation\Helpers\PaginationHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\PaginationHelperInterface::class);
        $this->assertNotNull($helper);

        $data = $helper->data(100, 100, 1500, '/abc', []);

        $this->assertEquals($data['previousPageLink'], '/abc?offset=0&limit=100');
        $this->assertEquals($data['nextPageLink'], '/abc?offset=200&limit=100');
    }
}
