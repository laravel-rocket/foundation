<?php

namespace LaravelRocket\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use LaravelRocket\Foundation\Helpers\TypeHelperInterface;

class TypeHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TypeHelperInterface::class;
    }
}
