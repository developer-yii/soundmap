<?php

namespace App\Providers;

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
        //
        $this->app['validator']->extend('min_array_size', function($attribute, $value, $parameters) {
            $data = $value;
            if( ! is_array($data)){
                return true;
            }
            return count($data) >= $parameters[0];
        });
    }
}
