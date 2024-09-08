<?php

namespace LaravelRocket\Foundation\Tests\Services;

use LaravelRocket\Foundation\Services\FileUploadS3ServiceInterface;
use LaravelRocket\Foundation\Tests\TestCase;

class FileUploadS3ServiceTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var FileUploadS3ServiceInterface $service */
        $service = app()->make(FileUploadS3ServiceInterface::class);
        $this->assertNotNull($service);
    }
}
