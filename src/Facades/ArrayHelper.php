<?php

namespace LaravelRocket\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use LaravelRocket\Foundation\Helpers\ArrayHelperInterface;

class ArrayHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ArrayHelperInterface::class;
    }
}
