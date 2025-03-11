<?php

namespace MrIncognito\DateConverter\Facades;

use Illuminate\Support\Facades\Facade;

class DateConverter extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dateConverter';
    }
}