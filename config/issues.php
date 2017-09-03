<?php

return [
    "driver" => "bitbucket",
    "credentials" => [
        "user"      => env("BITBUCKET_USER"),
        "password"  => env("BITBUCKET_PASSWORD")
    ],
    "repositories" => [
        "Xef Back"    => "revo-pos/revo-back",
        "Xef App"     => "revo-pos/revo-app",
        "Retail Back" => "revo-pos/revo-retail",
        "Retail App"  => "revo-pos/revo-retail-app",
        "Flow Back"   => "revo-pos/revo-flow-back",
        "Flow App"    => "revo-pos/revo-flow-app",
    ]
];