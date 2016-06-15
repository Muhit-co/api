<?php

namespace Muhit\Providers;

use Illuminate\Support\ServiceProvider;
use Muhit\Services\ResponseService;
use Muhit\Services\ToolService;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'responseservice',
            function () {
                return new ResponseService();
            }
        );

        $this->app->bind(
            'toolservice',
            function () {
                return new ToolService();
            }
        );
    }
}
