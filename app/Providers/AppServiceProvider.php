<?php

namespace App\Providers;

use App\Socialite\PassportProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;

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
        Socialite::extend('passport', function ($app) {
        $config = $app['config']['services.passport'];

        return new PassportProvider(
            $app['request'],
            $config['client_id'],
            $config['client_secret'],
            URL::to($config['redirect'])
        );
    });
    }
}
