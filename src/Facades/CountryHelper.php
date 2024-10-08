<?php

namespace LaravelRocket\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

class CountryHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LaravelRocket\Foundation\Helpers\DataHelperInterface::class;
    }
}
