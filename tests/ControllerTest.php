<?php

namespace Tests;

use Tests\helpers\MocksHttpClient;
use Tests\helpers\MocksSlimRequest;

class ControllerTest extends TestCase
{
    use MocksHttpClient, MocksSlimRequest;

    /**
     * @see \App\Controllers\ShorteningController::show()
     * @test
     */
    function a_json_response_is_returned_when_shortening_is_successful()
    {
        $response = $this->mockHttpClient($this->getBitlyDummyResponse('dummy_bitly_short_url'))
                         ->post(['url' => 'http://www.example.com', 'provider' => 'bitly']);

        $this->assertEquals([
            'long_url' => 'http://www.example.com',
            'url'      => 'dummy_bitly_short_url',
        ],
            json_decode($response->getBody(), true));
    }
}