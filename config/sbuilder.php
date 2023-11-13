<?php

return [
    'url' => env('SBUILDER_URL'),

    'soap' => [
        'key' => env('SBUILDER_SOAP_TOKEN'),
    ],

    'user_id' => (int) env('SBUILDER_USER_ID', -1),
];
