<?php
namespace LaravelRocket\Foundation\Tests\Services;

use LaravelRocket\Foundation\Services\MailServiceInterface;
use LaravelRocket\Foundation\Tests\TestCase;

class MailServiceTest extends TestCase
{
    public function testGetInstance()
    {
        /** @var MailServiceInterface $service */
        $service = app()->make(MailServiceInterface::class);
        $this->assertNotNull($service);
    }
}
