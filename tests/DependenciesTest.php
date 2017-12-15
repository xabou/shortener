<?php

namespace Tests;

use App\Providers\BitlyProvider;
use App\Providers\GoogleProvider;
use App\Providers\Shortener;
use App\Services\LoggingService;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Validation\Factory;
use Psr\Log\LoggerInterface;

class DependenciesTest extends TestCase
{
    /**
     * @see LoggingService::register()
     * @test
     */
    public function logging_dependency_is_added_to_the_container()
    {
        $this->assertInstanceOf(LoggerInterface::class, $this->container->get('logger'));
    }

    /**
     * @see \App\Services\ValidationService::register()
     * @test
     */
    public function validation_dependency_is_added_to_the_container()
    {
        $this->assertInstanceOf(Factory::class, $this->container->get('validator'));
    }

    /**
     * @see \App\Services\ShorteningService::register()
     * @test
     */
    public function shortening_dependency_is_added_to_the_container()
    {
        $this->assertInstanceOf(Shortener::class, $this->container->get('shortener'));
    }

    /**
     * @see \App\Services\ConfigurationService::register()
     * @test
     */
    public function configuration_dependency_is_added_to_the_container()
    {
        $this->assertInstanceOf(Config::class, $this->container->get('config'));
    }

    /**
     * @see \App\Services\HttpClientService::register()
     * @test
     */
    public function http_client_dependency_is_added_to_the_container()
    {
        $this->assertInstanceOf(ClientInterface::class, $this->container->get('httpClient'));
    }

    /**
     * @see \App\Services\CachingService::register()
     * @test
     */
    public function caching_dependency_is_added_to_the_container()
    {
        $this->assertInstanceOf(Cache::class, $this->container->get('cache'));
    }

    /**
     * @see \App\Providers\GoogleProvider
     * @test
     */
    public function googleProvider_dependency_is_added_to_the_container()
    {
        $this->assertInstanceOf(GoogleProvider::class, $this->container->get('googleProvider'));
    }

    /**
     * @see \App\Providers\BitlyProvider
     * @test
     */
    public function bitlyProvider_dependency_is_added_to_the_container()
    {
        $this->assertInstanceOf(BitlyProvider::class, $this->container->get('bitlyProvider'));
    }
}