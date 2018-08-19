<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TrainsServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('eurostar', function($app) {
            return new \App\Trains\Eurostar();
        });
        $this->app->bind('sncf', function($app) {
            return new \App\Trains\Sncf();
        });
        $this->app->bind('thalys', function($app) {
            return new \App\Trains\Thalys();
        });
    }
}
