<?php
namespace LaravelRocket\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

class StringHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LaravelRocket\Foundation\Helpers\StringHelperInterface';
    }
}
