<?php

namespace App\Providers;

use App\CustomClasses\SecurityFilter;
use Illuminate\Support\ServiceProvider;

class SecurityFilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('SecurityFilter', function($app) {
            return new SecurityFilter;
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
