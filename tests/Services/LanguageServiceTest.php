<?php
namespace LaravelRocket\Foundation\Tests\Services;

use LaravelRocket\Foundation\Services\LanguageServiceInterface;
use LaravelRocket\Foundation\Tests\TestCase;

class LanguageServiceTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var LanguageServiceInterface $service */
        $service = app()->make(LanguageServiceInterface::class);
        $this->assertNotNull($service);
    }
}
