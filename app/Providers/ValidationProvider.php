<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidationProvider extends ServiceProvider
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
        /*Validator::extend("check_stock", function ($attribute, $value, $parameters, $validator)
        use ($productRepo, $request){
            return $productRepo->checkStock()
        });*/
    }
}
