<?php

namespace App\Providers;

use App\EurostarAPI\Eurostar;
use Illuminate\Support\ServiceProvider;

class EurostarServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('eurostar', function($app) {
            return new Eurostar();
        });
    }
}
