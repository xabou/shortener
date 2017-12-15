<?php

namespace App\Services;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class LoggingService implements Register
{
    /**
     * Register the logging service.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function register()
    {
        $fileHandler = new RotatingFileHandler(__DIR__ . "/../../logs/shortener.log", 7);
        $logger = new Logger('app');
        $logger->pushHandler($fileHandler);

        return $logger;
    }
}