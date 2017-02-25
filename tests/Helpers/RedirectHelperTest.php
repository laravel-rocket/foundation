<?php namespace Tests\Helpers;

use Tests\TestCase;

class RedirectHelperTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \LaravelRocket\Foundation\Helpers\RedirectHelperInterface $helper */
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\RedirectHelperInterface::class);
        $this->assertNotNull($helper);
    }

}
