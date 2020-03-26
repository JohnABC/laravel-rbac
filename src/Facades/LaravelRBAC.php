<?php

namespace LaravelRBAC\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelRBAC extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravelrbac';
    }
}
