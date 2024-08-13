<?php

namespace App\Exception;

class EntityNotFoundException extends \RuntimeException
{

    public function __construct(string $message, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}