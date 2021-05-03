<?php

namespace App\Providers;

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
        $this->validations();
        $this->messageValidationsWithParameter();
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

    /**
     * Register Validations.
     */
    private function validations()
    {
        app('validator')->extend('greaterthanzero', 'App\Rules\Common@greaterThanZero');
        app('validator')->extend('verifylenght', 'App\Rules\Common@verifyLenght');
        app('validator')->extend('existzipcode', 'App\Rules\Query@existZipCode');
        app('validator')->extend('existfieldintorequest', 'App\Rules\Common@existFieldIntoRequest');
    }

    /**
     * Sets the parameter to a message variable .
     */
    private function messageValidationsWithParameter()
    {
        app('validator')->replacer('verifylenght', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':lenght', $parameters[0], $message);
        });
    }
}