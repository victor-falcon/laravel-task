<?php

namespace VictorFalcon\LaravelTask\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelTask extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-task';
    }
}
