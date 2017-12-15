<?php

namespace App\Services;

use App\Exceptions\Handler;
use Psr\Log\LoggerInterface;

class ErrorHandlingService implements Register
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * ErrorHandlingService constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Register the error handling service.
     *
     * @return \Closure
     */
    public function register()
    {
        return function ($request, $response, $exception) {
            // Instantiate exception handler.
            $handler = new Handler($this->logger);
            // Log exception
            $handler->report($exception);

            // Render response.
            return $handler->render($exception, $response);
        };
    }
}