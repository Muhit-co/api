<?php

namespace Muhit\Facades;

use Illuminate\Support\Facades\Facade;

class ToolService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'toolservice';
    }
}