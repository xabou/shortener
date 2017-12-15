<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class Handler
{
    /**
     * The logger.
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Handler constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Exception $exception
     * @param Response $response
     * @return Response
     */
    public function render(Exception $exception, Response $response)
    {
        if ($exception instanceof ValidationException) {
            return $response->withJson($exception->errors()->toArray(), 422);
        }

        if ($exception instanceof GuzzleException) {
            return $response->withJson(['error' => ['message' => $exception->getMessage()]], 503);
        }

        // Default Error Handling Response
        return $response->withStatus(500)
                        ->withHeader('Content-Type', 'text/html')
                        ->write('Something went wrong!');
    }

    /**
     * Log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return;
        }

        $this->logger->error($exception);
    }
}