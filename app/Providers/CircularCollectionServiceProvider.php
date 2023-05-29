<?php

namespace App\Providers;

use App\CustomClasses\CircularCollection;
use Illuminate\Support\ServiceProvider;

class CircularCollectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CircularCollection', function($app) {
            return new CircularCollection;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
