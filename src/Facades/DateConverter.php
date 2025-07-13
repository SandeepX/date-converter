<?php

namespace MrIncognito\DateConverter\Facades;

use Illuminate\Support\Facades\Facade;

class DateConverter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'dateConverter';
    }
}
