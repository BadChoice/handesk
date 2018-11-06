<?php

return [
    'api_token'       => env('API_TOKEN', 'the-api-token'),
    'leads'           => env('HANDESK_LEADS_ENABLED', true),
    'roadmap'         => env('HANDESK_ROADMAP_ENABLED', true),
    'sendRatingEmail' => env('HANDESK_RATING_EMAIL_ENABLED', true),
];
