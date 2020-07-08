<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
        Schema::defaultStringLength(191);

        Inertia::share('auth.user', function () {
            if (Auth::user()) {
                return [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'username' => Auth::user()->username,
                    'role' => Auth::user()->role
                ];
            }
        });
    }
}
