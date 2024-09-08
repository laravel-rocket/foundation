<?php

namespace LaravelRocket\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use LaravelRocket\Foundation\Helpers\DataHelperInterface;

class DataHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DataHelperInterface::class;
    }
}
