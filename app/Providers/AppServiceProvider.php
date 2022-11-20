<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

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
        // Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
        //     $explode = explode(',', $value);
        //     $allow = ['png', 'jpg', 'jpeg'];
        //     $format = str_replace(
        //         [
        //             'data:image/',
        //             ';',
        //             'base64',
        //         ],
        //         [
        //             '', '', '',
        //         ],
        //         $explode[0]
        //     );

        //     // check file format
        //     if (!in_array($format, $allow)) {
        //         return false;
        //     }

        //     // check base64 format
        //     if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
        //         return false;
        //     }

        //     return true;
        // });

        if(app()->environment('production')){
            URL::forceScheme('https');  
        }
        
        // $card = \Session::get('card');
        // view()->share('card', $card);
    }
}