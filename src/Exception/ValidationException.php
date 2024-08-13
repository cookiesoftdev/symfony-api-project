<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class ValidationException extends ValidatorException
{

    private $violations;

    public function __construct(ConstraintViolationListInterface $violations, string $message = 'Validation failed', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->violations = $violations;
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }

}