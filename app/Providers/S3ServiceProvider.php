<?php

namespace App\Providers;

use App\CustomClasses\S3;
use Illuminate\Support\ServiceProvider;

class S3ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('S3', function($app) {
            return new S3;
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
