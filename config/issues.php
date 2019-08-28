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
        'Xef Back'      => 'revo-pos/revo-back',
        'Xef App'       => 'revo-pos/revo-app',
        'Retail Back'   => 'revo-pos/revo-retail',
        'Retail App'    => 'revo-pos/revo-retail-app',
        'Flow Back'     => 'revo-pos/revo-flow-back',
        'Flow App'      => 'revo-pos/revo-flow-app',
        'In Touch Back' => 'revo-pos/revo-loyalty-app',
        'In Touch App'  => 'revo-pos/revo-loyalty',
        'mPos'          => 'revo-pos/revo-mpos',
        'Kds'           => 'revo-pos/revo-kds',
        'Revo Stock'    => 'revo-pos/revo-stock',
        'Revo Control'  => 'revo-pos/revo-control',
        'Revo Display'  => 'revo-pos/revo-display',
    ],
];
