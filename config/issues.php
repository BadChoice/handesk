<?php

return [
    'driver'      => env('ISSUES_DRIVER', 'bitbucket'),
    'credentials' => [
        'driver'   => env('BITBUCKET_DRIVER', 'basic'), //basic, oauth
        'key'      => env('BITBUCKET_KEY'),           //oauth
        'secret'   => env('BITBUCKET_SECRET'),        //oauth
        'user'     => env('BITBUCKET_USER'),          //basic auth
        'password' => env('BITBUCKET_PASSWORD'),       //basic auth
    ],
    'repositories' => [
        'servicecertainty'      => 'revo-pos/revo-back',
        'windscreenpro'       => 'revo-pos/revo-app',
        'AI'   => 'revo-pos/revo-retail',
        'Belron'    => 'revo-pos/revo-retail-app',
    ],
];
