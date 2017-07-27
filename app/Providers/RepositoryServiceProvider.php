<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\OrderContract',
            'App\Repositories\OrderRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\ProductContract',
            'App\Repositories\ProductRepository'
        );
         $this->app->bind(
            'App\Repositories\Contracts\SellerContract',
            'App\Repositories\SellerRepository'
        );
         $this->app->bind(
             'App\Repositories\Contracts\RequestContract',
             'App\Repositories\RequestRepository'
         );
    }
}
