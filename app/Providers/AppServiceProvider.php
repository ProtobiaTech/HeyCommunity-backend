<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

use App\User;
use TenantScope;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('UniqueInTenantUser', function($attribute, $value, $parameters, $validator) {
            $field = isset($parameters[1]) ? $parameters[1] : $attribute;
            return !User::where($field, $value)->exists();
        });

        Validator::replacer('UniqueInTenantUser', function($message, $attribute, $rule, $parameters) {
            return 'The ' . $attribute . ' has already been taken.';
        });
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
}
