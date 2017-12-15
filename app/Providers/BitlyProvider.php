<?php

namespace App\Providers;

use App\Exceptions\GuzzleException;

class BitlyProvider extends Provider implements Shortener
{
    /**
     * Shorten given string by invoking Google URL shortener.
     *
     * @param string $url
     * @return string
     * @link https://dev.bitly.com/api.html
     */
    public function shorten(string $url)
    {
        $this->url = $url;

        if ( ! $response = $this->cache->get($key = "bitly_$url")) {
            $response = $this->callService();
            $this->cache->put($key, $response, $this->config->get('cache.lifetime'));
        }

        return $response['data']['url'];
    }

    /**
     * Get the URL for Google's shortening API.
     *
     * @return string
     */
    public function getURL()
    {
        return $this->config->get('providers.bitly.url');
    }

    /**
     * Get the Request options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            'query' => [
                'access_token' => $this->config->get('providers.bitly.key'),
                'longUrl'      => $this->url
            ]
        ];
    }

    /**
     * Perform an HTTP call to Bitly service.
     *
     * @return array
     * @throws \App\Exceptions\GuzzleException
     */
    protected function callService()
    {
        try {
            $response = $this->client->request('GET', $this->getURL(), $this->getOptions());
            $response = $this->decodeResponse($response);
        } catch (\Exception $exception) {
            throw new GuzzleException($exception->getMessage(), $exception);
        }

        if ($response['status_code'] !== 200) {
            throw new GuzzleException(json_encode($response));
        }

        return $response;
    }
}