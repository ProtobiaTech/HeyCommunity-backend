<?php

return [

    'multi-auth' => [
        'tenant' => [
            'driver' => 'eloquent',
            'model'  => App\Tenant::class
        ],
        'admin' => [
            'driver' => 'eloquent',
            'model'  => App\Admin::class
        ],
        'user' => [
            'driver' => 'eloquent',
            'model'  => App\User::class
        ],
    ],

    'password' => [
        'email'  => 'emails.password',
        'table'  => 'password_resets',
        'expire' => 60,
    ],

];
