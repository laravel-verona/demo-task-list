<?php

namespace Todo\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Tasks extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Todo\Tasks\Tasks::class;
    }
}