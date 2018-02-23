<?php
namespace LaravelRocket\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use LaravelRocket\Foundation\Helpers\FileHelperInterface;

class FileHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FileHelperInterface::class;
    }
}
