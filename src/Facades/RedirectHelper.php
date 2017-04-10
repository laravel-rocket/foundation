<?php
namespace LaravelRocket\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

class RedirectHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LaravelRocket\Foundation\Helpers\RedirectHelperInterface';
    }
}
