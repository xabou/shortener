<?php

namespace Tests\helpers;

use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Uri;

trait MocksSlimRequest
{
    /**
     * Mock an HTTP POST request.
     *
     * @param array $body
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function post($body = [])
    {
        $method = 'POST';
        $environment = Environment::mock([
            'REQUEST_METHOD' => $method,
            'REQUEST_URI'    => '/shorten',
            'CONTENT_TYPE'   => 'application/x-www-form-urlencoded',
        ]);

        $uri = Uri::createFromEnvironment($environment);
        $headers = Headers::createFromEnvironment($environment);
        $request = new Request($method, $uri, $headers, [], $environment->all(), new RequestBody());
        $request = $request->withParsedBody($body);

        $this->container['request'] = $request;

        return $this->app->run(true);
    }
}