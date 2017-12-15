<?php

namespace App\Services;

use Illuminate\Config\Repository;

class ConfigurationService implements Register
{
    /**
     * Register the configuration service.
     *
     * @return \Illuminate\Config\Repository
     */
    public function register()
    {
        $repository = new Repository();

        foreach ($this->getConfigurationFiles() as $key => $path) {
            $repository->set($key, require $path);
        }

        return $repository;
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @return array
     */
    protected function getConfigurationFiles()
    {
        $configPath = __DIR__ . '/../../config/';

        $files = [];

        foreach (glob("$configPath*.php") as $path) {
            $files[str_replace('.php', '', str_replace($configPath, '', $path))] = $path;
        }

        return $files;
    }
}