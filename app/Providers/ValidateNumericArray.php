<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class ValidateNumericArray extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('numericArray', function($attribute, $value, $parameters, $validator)
        {
            foreach($value as $v) {
                if(!is_int($v)) return false;
            }
            return true;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
