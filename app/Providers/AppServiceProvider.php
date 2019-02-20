<?php

namespace App\Providers;

use App\Helper\Amplitude;
use App\Helper\ImageHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Laravel\Dusk\DuskServiceProvider;
use App\Helper\AppHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \URL::forceScheme('https');
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
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind('appHelper', function($app) {
            return app()->make(AppHelper::class);
        });
        $this->app->bind('imageHelper', function($app) {
            return app()->make(ImageHelper::class);
        });
        $this->app->bind('amplitude', function($app) {
            return app()->make(Amplitude::class);
        });
    }
}
