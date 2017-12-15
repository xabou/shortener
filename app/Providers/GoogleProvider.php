<?php

namespace App\Providers;

use App\Exceptions\GuzzleException;

class GoogleProvider extends Provider implements Shortener
{
    /**
     * Shorten given string by invoking Google URL shortener.
     *
     * @param string $url
     * @return string
     * @link https://developers.google.com/url-shortener/
     */
    public function shorten(string $url)
    {
        $this->url = $url;

        if ( ! $response = $this->cache->get($key = "google_$url")) {
            $response = $this->callService();
            $this->cache->put($key, $response, $this->config->get('cache.lifetime'));
        }

        return $response['id'];
    }

    /**
     * Get the URL for Google's shortening API.
     *
     * @return string
     */
    public function getURL()
    {
        return $this->config->get('providers.google.url');
    }

    /**
     * Get the Request options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            'json'  => [
                'longUrl' => $this->url
            ],
            'query' => [
                'key' => $this->config->get('providers.google.key')
            ]
        ];
    }

    /**
     * Perform an HTTP call to Google service.
     *
     * @return array
     * @throws \App\Exceptions\GuzzleException
     */
    protected function callService()
    {
        try {
            $response = $this->client->request('POST', $this->getURL(), $this->getOptions());

            return $this->decodeResponse($response);
        } catch (\Exception $exception) {
            throw new GuzzleException($exception->getMessage(), $exception);
        }
    }
}