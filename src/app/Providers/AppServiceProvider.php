<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
//https通信では以下有効
//use Illuminate\Support\Facades\URL;

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
        //https通信では以下有効
        //URL::forceScheme('https');

        //どのページでもログインしているユーザーのrole_idを参照する
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('role_id', Auth::user()->role_id);
            }
        });
    }
}
