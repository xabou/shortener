<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Shortening Provider
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the shortening providers below you wish
    | to use as your default provider.
    |
    */

    'default' => 'google',

    /*
     |--------------------------------------------------------------------------
     | Shortening Providers
     |--------------------------------------------------------------------------
     |
     | Here are each of the shortening providers setup for the application.
     | This file provides the location for storing the credentials for
     | third party services such as Google, Bitly and others.
     |
     */

    'google' => [
        'url' => 'https://www.googleapis.com/urlshortener/v1/url',
        'key' => ''
    ],

    'bitly' => [
        'url' => 'https://api-ssl.bitly.com/v3/shorten',
        'key' => ''
    ]
];
