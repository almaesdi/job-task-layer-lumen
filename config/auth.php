
<?php
return[
    'defaults' => [
        'guard' => env("AUTH_GUARD", "api"),
        'passwords' => 'users',
    ],
    'guards' => [
        'external' => [
            'driver' => 'web',
            'provider' => 'webservice',
        ],
        'api' => [
            'driver' => 'token',
            //'provider' => 'webservice',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'webservice' => [
            'driver' => 'webservice',
            'model' => App\User::class,
        ],
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],
];
