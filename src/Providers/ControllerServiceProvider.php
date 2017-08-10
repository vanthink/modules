<?php

namespace Vanthink\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Vanthink\Modules\Dispatcher\ControllerDispatcher;

class ControllerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('illuminate.route.dispatcher', function ($app) {
            return new ControllerDispatcher($app['router'], $app);
        });
    }
}
