<?php

namespace App\Services;

use Illuminate\Contracts\Config\Repository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;

class ShorteningService implements Register
{
    /**
     * The HTTP request.
     *
     * @var \Psr\Http\Message\RequestInterface
     */
    protected $request;
    /**
     * The application container.
     *
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;
    /**
     * The config repository.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * ShorteningService constructor.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \Psr\Container\ContainerInterface $container
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(RequestInterface $request, ContainerInterface $container, Repository $config)
    {
        $this->request = $request;
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * Register the shortening service.
     *
     * @return \App\Providers\Shortener
     */
    public function register()
    {
        // Get provider parameter or fallback to default.
        $provider = $this->request->getParsedBodyParam('provider', $this->config->get('providers.default'));

        return $this->container->get($provider . 'Provider');
    }
}