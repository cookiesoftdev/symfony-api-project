<?php

namespace App\Dto;

class ErrorDetailDTO
{
    private $message;
    private $statusCode;
    private $validationErrors;

    public function __construct(string $message, int $statusCode, array $validationErrors = [])
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->validationErrors = $validationErrors;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return ErroDetailDTO
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return ErroDetailDTO
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    /**
     * @param mixed $validationErrors
     * @return ErrorDetailDTO
     */
    public function setValidationErrors($validationErrors)
    {
        $this->validationErrors = $validationErrors;
        return $this;
    }

    public function addValidationError(string $field, string $error): void
    {
        $this->validationErrors[$field][] = $error;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'status_code' => $this->statusCode,
            'validation_errors' => $this->validationErrors,
        ];
    }

}