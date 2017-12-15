<?php

namespace App\Controllers;

use App\Providers\Shortener;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShorteningController
{
    /**
     * The URL shortener.
     *
     * @var \App\Providers\Shortener
     */
    protected $shortener;

    /**
     * ShorteningController constructor.
     *
     * @param \App\Providers\Shortener $shortener
     */
    public function __construct(Shortener $shortener)
    {
        $this->shortener = $shortener;
    }

    /**
     * Shorten the given string.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function show(Request $request, Response $response)
    {
        $longUrl = $request->getParsedBodyParam('url');

        $url = $this->shortener->shorten($longUrl);

        return $response->withJson([
            'long_url' => $longUrl,
            'url'      => $url,
        ]);
    }
}