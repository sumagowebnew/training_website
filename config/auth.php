<?php

return [
    'defaults' => [
        'guard' => 'admin_api',
        'passwords' => 'users',
    ],

    'guards' => [
        'admin_api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\Models\User::class
        ]
    ]
];