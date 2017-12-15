<?php

namespace App\Services;

use GuzzleHttp\Client;

class HttpClientService implements Register
{
    /**
     * Register the HTTP client service.
     *
     * @return \GuzzleHttp\Client
     */
    public function register()
    {
        return new Client();
    }
}