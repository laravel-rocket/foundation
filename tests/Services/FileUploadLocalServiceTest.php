<?php
namespace LaravelRocket\Foundation\Tests\Services;

use LaravelRocket\Foundation\Services\FileUploadLocalServiceInterface;
use LaravelRocket\Foundation\Tests\TestCase;

class FileUploadLocalServiceTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var FileUploadLocalServiceInterface $service */
        $service = app()->make(FileUploadLocalServiceInterface::class);
        $this->assertNotNull($service);
    }
}
