<?php

namespace LaravelRocket\Foundation\Tests\Services;

use LaravelRocket\Foundation\Services\ExportServiceInterface;
use LaravelRocket\Foundation\Tests\TestCase;

class ExportServiceTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var \LaravelRocket\Foundation\Services\ExportServiceInterface $service */
        $service = app()->make(ExportServiceInterface::class);
        $this->assertNotNull($service);
    }
}
