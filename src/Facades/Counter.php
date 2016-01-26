<?php namespace CupOfTea\Counter\Facades;

use Illuminate\Support\Facades\Facade;

class Counter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'CupOfTea\Counter\Counter';
    }
}
