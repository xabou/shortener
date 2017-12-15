<?php

namespace Tests;

use Tests\helpers\MocksHttpClient;

class CachingTest extends TestCase
{
    use MocksHttpClient;

    /**
     * @see \App\Providers\GoogleProvider::shorten()
     * @test
     */
    function a_url_is_stored_in_cache_after_a_call_to_an_external_service()
    {
        $url = 'http://www.example.com';

        $this->assertFalse($this->container->get('cache')->has("google_$url"));

        $this->mockHttpClient()->container->get('googleProvider')->shorten('http://www.example.com');

        $this->assertTrue($this->container->get('cache')->has("google_$url"));
    }

    /**
     * @see \App\Providers\GoogleProvider::shorten()
     * @test
     */
    function a_url_is_fetched_from_cache()
    {
        $url = 'http://www.example.com';

        $shortUrl = $this->mockHttpClient($this->getGoogleDummyResponse('dummy_url'))
            ->container
            ->get('googleProvider')
            ->shorten($url);

        $shortUrlFromCache = $this->mockHttpClient($this->getGoogleDummyResponse('another_url'))
            ->container
            ->get('googleProvider')
            ->shorten($url);

        $this->assertEquals($shortUrl, $shortUrlFromCache);
    }

    /**
     * @see \App\Providers\GoogleProvider::shorten(),\App\Providers\BitlyProvider::shorten()
     * @test
     */
    function the_cache_key_has_the_provider_name_as_prefix()
    {
        $url = 'http://www.example.com';

        $this->mockHttpClient()->container->get('googleProvider')->shorten($url);
        $this->mockHttpClient($this->getBitlyDummyResponse())->container->get('bitlyProvider')->shorten($url);

        $this->assertTrue($this->container->get('cache')->has("google_$url"));
        $this->assertTrue($this->container->get('cache')->has("bitly_$url"));
    }
}