<?php

return [

    'multi-auth' => [
        'tenant' => [
            'driver'    =>  'eloquent',
            'model'     =>  App\Tenant::class,
        ],

        'user' => [
            'driver'    =>  'eloquent',
            'model'     =>  App\User::class,
        ],
    ]


];
