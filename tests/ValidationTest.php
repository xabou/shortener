<?php

namespace Tests;

use Tests\helpers\MocksHttpClient;
use Tests\helpers\MocksSlimRequest;

class ValidationTest extends TestCase
{
    use MocksHttpClient, MocksSlimRequest;

    /**
     * @see \App\Middlewares\ValidationMiddleware::getRules()
     * @test
     */
    function a_request_requires_a_url_parameter()
    {
        $response = $this->post();
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertContains('The url field is required.', (string)$response->getBody());
    }

    /**
     * @see \App\Middlewares\ValidationMiddleware::getRules()
     * @test
     */
    function a_request_can_optionally_have_a_provider_parameter()
    {
        $response = $this->mockHttpClient()->post(['url' => 'http://www.example.com']);
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->mockHttpClient()->post(['provider' => 'bitly', 'url' => 'http://www.example.com']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @see \App\Middlewares\ValidationMiddleware::getRules()
     * @test
     */
    function a_request_expects_the_url_parameter_to_be_in_the_right_format()
    {
        $response = $this->mockHttpClient()->post(['url' => 'http://www.example.com']);
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->post(['url' => 'example']);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertContains('The url format is invalid.', (string)$response->getBody());

        $response = $this->post(['url' => 'www.example.com']);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertContains('The url format is invalid.', (string)$response->getBody());
    }

    /**
     * @see \App\Middlewares\ValidationMiddleware::getRules()
     * @test
     */
    function a_request_expects_the_provider_parameter_to_be_supported()
    {
        $response = $this->mockHttpClient()->post(['provider' => 'google', 'url' => 'http://www.example.com']);
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->mockHttpClient()->post(['provider' => 'bitly', 'url' => 'http://www.example.com']);
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->post(['provider' => 'dummy']);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertContains('The selected provider is invalid.', (string)$response->getBody());
    }
}