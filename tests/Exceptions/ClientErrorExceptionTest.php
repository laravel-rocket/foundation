<?php

namespace LaravelRocket\Foundation\Tests\Exceptions;

use Illuminate\Support\Str;
use LaravelRocket\Foundation\Exceptions\ClientErrorException;
use LaravelRocket\Foundation\Tests\TestCase;

class ClientErrorExceptionTest extends TestCase
{
    public function testCreateException()
    {
        $name = Str::random(10);
        $exception = new ClientErrorException($name);
        $this->assertNotEmpty($exception);

        $this->assertEquals($name, $exception->getError());
    }
}
