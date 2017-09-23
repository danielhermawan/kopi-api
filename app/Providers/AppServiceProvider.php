<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Pusher\Pusher;

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
        $this->app->singleton('InternalClient', function($app) {
            return new Client([
                'base_uri' => env('APP_URL'),
                'http_errors' => false
            ]);
        });

        $this->app->singleton('PusherClient', function($app) {
            return new Pusher(env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                ['cluster' => env('PUSHER_CLUSTER')]);
        });
    }
}
