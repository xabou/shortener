<?php

namespace App\Providers;

use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use Psr\Http\Message\ResponseInterface;

abstract class Provider
{
    /**
     * The HTTP client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;
    /**
     * The config repository.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;
    /**
     * The URL to shorten.
     *
     * @var string
     */
    protected $url;
    /**
     * The cache repository.
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Provider constructor.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Illuminate\Contracts\Cache\Repository $cache
     */
    public function __construct(ClientInterface $client, Config $config, Cache $cache)
    {
        $this->client = $client;
        $this->config = $config;
        $this->cache = $cache;
    }

    /**
     * Perform an HTTP call to third-party service.
     *
     * @return array
     * @throws \App\Exceptions\GuzzleException
     */
    abstract protected function callService();

    /**
     * Decode given response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return array
     */
    protected function decodeResponse(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}