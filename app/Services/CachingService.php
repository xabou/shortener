<?php

namespace App\Services;

use Illuminate\Cache\CacheManager;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;

class CachingService implements Register
{
    /**
     * The config repository.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * ShorteningService constructor.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Register the caching service.
     *
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function register()
    {
        if ( ! $this->config->get('cache.enabled')) {
            $this->config->set('cache.default', 'array');
        }

        $cacheManager = new CacheManager($this->createContainer());

        return $cacheManager->store();
    }

    /**
     * Create Illuminate container based on cache configuration.
     *
     * @return Container
     */
    protected function createContainer()
    {
        $container = new Container();

        // The CacheManager creates the cache "repository" based on config values.
        $default = $this->config->get('cache.default');

        if ($default == 'array') {
            $container['config'] = [
                'cache.default'      => 'array',
                'cache.stores.array' => [
                    'driver' => $this->config->get('cache.stores.array.driver'),
                ]
            ];
        } elseif ($default == 'file') {
            $container['config'] = [
                'cache.default'     => 'file',
                'cache.stores.file' => [
                    'driver' => $this->config->get('cache.stores.file.driver'),
                    'path'   => $this->config->get('cache.stores.file.path')
                ]
            ];
            // To use the file cache driver we need an instance of Illuminate's Filesystem.
            $container['files'] = new Filesystem;
        }

        return $container;
    }
}