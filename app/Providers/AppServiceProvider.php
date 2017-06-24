<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ( env( 'APP_DEBUGBAR', false ) ) {
            $this->app->register( 'Barryvdh\Debugbar\ServiceProvider' );
            AliasLoader::getInstance()->alias( 'Debugbar', 'Barryvdh\Debugbar\Facade' );
        }
    }
}
