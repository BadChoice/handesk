<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailchimp' => [
        'api_key'     => env('MAILCHIMP_API_KEY'),
        'tag_list_id' => [
            'xef'    => '499b95d54d',
            'retail' => '8012b3aeab',
            'flow'   => 'c176e8feaf',
            'web'    => 'ad27d6f6f8',
        ],
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'bitbucket' => [
        'oauth' => [
            'key'    => env('BITBUCKET_OAUTH_KEY'),
            'secret' => env('BITBUCKET_OAUTH_SECRET'),
        ],
        'user'            => env('BITBUCKET_USER'),
        'password'        => env('BITBUCKET_PASSWORD'),
        'developersGroup' => 'Developers',
    ],

];
