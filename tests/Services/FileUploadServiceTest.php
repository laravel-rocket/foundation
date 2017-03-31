<?php

namespace LaravelRocket\Foundation\Tests\Services;

use LaravelRocket\Foundation\Services\FileUploadServiceInterface;
use LaravelRocket\Foundation\Tests\TestCase;

class FileUploadServiceTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var FileUploadService $service */
        $service = app()->make(FileUploadServiceInterface::class);
        $this->assertNotNull($service);
    }
}
