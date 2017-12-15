<?php

namespace Tests\helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

trait MocksHttpClient
{
    /**
     * Mocks and binds Http client to the container.
     *
     * @param array $responseBody
     * @return $this
     */
    protected function mockHttpClient(array $responseBody = [])
    {
        $responseBody = $responseBody ? : $this->getGoogleDummyResponse();

        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($responseBody));

        $this->container['httpClient'] = Mockery::mock(Client::class)
                                                ->shouldReceive('request')
                                                ->andReturn($response)
                                                ->getMock();

        return $this;
    }

    /**
     * Get a dummy Google shortening API response.
     *
     * @param string $url
     * @return array
     */
    protected function getGoogleDummyResponse(string $url = 'dummy')
    {
        return [
            'kind'    => 'urlshortener#url',
            'id'      => $url,
            'longUrl' => 'http://www.example.com',
        ];
    }

    /**
     * Get a dummy Bitly shortening API response.
     *
     * @param string $url
     * @return array
     */
    protected function getBitlyDummyResponse(string $url = 'dummy')
    {
        return [
            'status_code' => 200,
            'status_txt'  => 'OK',
            'data'        =>
                [
                    'url'         => $url,
                    'hash'        => '2B039HT',
                    'global_hash' => '3hDSUb',
                    'long_url'    => 'http://www.example.com',
                    'new_hash'    => 0,
                ],
        ];
    }
}