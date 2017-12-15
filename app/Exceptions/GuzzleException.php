<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class GuzzleException extends Exception
{
    /**
     * GuzzleException constructor.
     *
     * @param string $message
     * @param \Throwable|null $previous
     */
    public function __construct($message, Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}