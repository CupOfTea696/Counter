<?php namespace CupOfTea\Counter;

use Illuminate\Support\ServiceProvider;

class CounterServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Counter::class, function ($app) {
            return new Counter;
        });
    }
}
