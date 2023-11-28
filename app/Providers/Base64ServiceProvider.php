<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class Base64ServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('base64pdf', 'App\Validators\Base64Validator@validateBase64Pdf');

        Validator::replacer('base64pdf', function ($message, $attribute, $rule, $parameters) {
            return str_replace([':attribute', ':values'], [$attribute, implode(', ', $parameters)], $message);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
