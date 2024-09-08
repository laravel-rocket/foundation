<?php

namespace LaravelRocket\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

class URLHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LaravelRocket\Foundation\Helpers\URLHelperInterface';
    }
}
