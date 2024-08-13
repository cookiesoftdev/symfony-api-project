<?php

namespace App\Util;

use App\Dto\ErrorDetailDTO;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationUtil
{

    public static function createValidationErrorDetail(
        ConstraintViolationListInterface $violations,
        string $message,
        int $statusCode
    ): ErrorDetailDTO {
        $errorDetail = new ErrorDetailDTO($message, $statusCode);

        foreach ($violations as $violation) {
            $errorDetail->addValidationError($violation->getPropertyPath(), $violation->getMessage());
        }

        return $errorDetail;
    }

}