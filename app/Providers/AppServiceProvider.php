<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Gate::define('admin', function(User $user) {
            return $user->hasRole(['admin', 'superadmin']);
        });

        Gate::define('superadmin', function(User $user) {
            return $user->hasRole(['superadmin']);
        });

        Blade::if('admin', function($condition = true) {
            return request()->user()?->can('admin') && $condition;
        });

        Blade::if('superadmin', function($condition = true) {
            return request()->user()?->can('superadmin') && $condition;
        });
    }
}
