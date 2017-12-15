<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class ValidationService implements Register
{
    /**
     * Register the validation service.
     *
     * @return \Illuminate\Validation\Factory
     */
    public function register()
    {
        $loader = new FileLoader(new Filesystem, __DIR__ . '/../../lang');
        $translator = new Translator($loader, 'en');

        return new Factory($translator);
    }
}