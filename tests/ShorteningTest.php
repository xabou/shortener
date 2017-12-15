<?php

namespace Tests;

use App\Exceptions\GuzzleException;

class ShorteningTest extends TestCase
{
    /*
    |--------------------------------------------------------------------------
    | Time consuming Tests
    |--------------------------------------------------------------------------
    |
    | Following tests hit the API of the third-party services. Instead of,
    | mocking the HttpClient, like we did in other tests, we want to
    | perform an actual request to make sure that the response of
    | the external service is properly handled.
    |
    */

    /**
     * @see \App\Providers\GoogleProvider::shorten()
     * @test
     */
    function google_shortener_handles_given_url()
    {
        $url = $this->container->get('googleProvider')->shorten('http://www.example.com');

        $this->assertContains('https://goo.gl/', $url);
    }

    /**
     * @see \App\Providers\BitlyProvider::shorten()
     * @test
     */
    function bitly_shortener_handles_given_url()
    {
        $url = $this->container->get('bitlyProvider')->shorten('http://www.example.com');

        $this->assertContains('http://bit.ly/', $url);
    }

    /**
     * @see \App\Providers\BitlyProvider::shorten()
     * @test
     */
    function a_guzzle_exception_is_thrown_when_a_request_to_the_provider_fails()
    {
        $this->expectException(GuzzleException::class);

        // Set Google API key to a dummy value.
        $this->container->get('config')->set('providers.google.key', 'dummy');

        $this->container->get('shortener')->shorten('http://www.example.com');
    }
}