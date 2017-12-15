<?php

namespace Tests;

use App\Providers\BitlyProvider;
use App\Providers\GoogleProvider;
use Tests\helpers\MocksHttpClient;
use Tests\helpers\MocksSlimRequest;

class ProvidersTest extends TestCase
{
    use MocksHttpClient, MocksSlimRequest;

    /**
     * @see \App\Services\ShorteningService::register()
     * @test
     */
    function a_google_provider_is_instantiated_by_request_parameter()
    {
        $this->mockHttpClient()->post(['provider' => 'google']);

        $this->assertInstanceOf(GoogleProvider::class, $this->container->get('shortener'));
    }

    /**
     * @see \App\Services\ShorteningService::register()
     * @test
     */
    function a_bitly_provider_is_instantiated_by_request_parameter()
    {
        $this->mockHttpClient()->post(['provider' => 'bitly']);

        $this->assertInstanceOf(BitlyProvider::class, $this->container->get('shortener'));
    }

    /**
     * @see \App\Services\ShorteningService::register()
     * @test
     */
    function by_default_google_provider_is_instantiated()
    {
        $this->mockHttpClient()->post();

        $this->assertInstanceOf(GoogleProvider::class, $this->container->get('shortener'));
    }
}