<?php
namespace LaravelRocket\Foundation\Tests\Exceptions;

use LaravelRocket\Foundation\Exceptions\ClientErrorException;
use LaravelRocket\Foundation\Tests\TestCase;

class ClientErrorExceptionTest extends TestCase
{
    public function testCreateException()
    {
        $name      = str_random(10);
        $exception = new ClientErrorException($name);
        $this->assertNotEmpty($exception);

        $this->assertEquals($name, $exception->getError());
    }
}
