<?php

namespace LaravelRocket\Foundation\Tests\Services;

use LaravelRocket\Foundation\Services\ImageServiceInterface;
use LaravelRocket\Foundation\Tests\TestCase;

class ImageServiceTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var ImageServiceInterface $service */
        $service = app()->make(ImageServiceInterface::class);
        $this->assertNotNull($service);
    }
}
