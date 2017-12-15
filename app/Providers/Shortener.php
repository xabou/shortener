<?php

namespace App\Providers;

interface Shortener
{
    /**
     * Shorten given string by invoking third party service.
     *
     * @param string $url
     * @return string
     * @throws \App\Exceptions\GuzzleException
     */
    public function shorten(string $url);

    /**
     * Get the URL for provider's API.
     *
     * @return string
     */
    public function getURL();

    /**
     * Get the Request options.
     *
     * @return array
     */
    public function getOptions();
}