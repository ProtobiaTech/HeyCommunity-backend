<?php

return [

    'multi-auth' => [
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
