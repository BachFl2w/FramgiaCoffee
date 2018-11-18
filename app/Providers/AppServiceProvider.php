<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts/header', function($view) {
            if (Auth::check()) {
                $currentUser = Auth::user();
                $view->with('currentUser', $currentUser);
            }
        });

        view()->composer('layouts/app_client', function($view) {
            if (Auth::check()) {
                $currentUser = Auth::user();
                $view->with('currentUser', $currentUser);
            } else {
                $view->with('currentUser', 'Guest');
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
