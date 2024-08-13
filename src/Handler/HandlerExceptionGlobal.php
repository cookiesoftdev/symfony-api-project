<?php

namespace App\Handler;

use App\Dto\ErrorDetailDTO;
use App\Exception\EntityNotFoundException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

#[AsEventListener]
class HandlerExceptionGlobal
{

    public function __invoke(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse();

        if ($exception instanceof HttpExceptionInterface) {
            $errorDetail = new ErrorDetailDTO($exception->getMessage(), $exception->getStatusCode());
        }elseif ($exception instanceof EntityNotFoundException) {
            $errorDetail = new ErrorDetailDTO($exception->getMessage(), JsonResponse::HTTP_NOT_FOUND);
        } elseif ($exception instanceof ValidatorException) {
            $errorDetail = $this->createValidationErrorDetail($exception->getViolations(), 'Erro de validação', 400);
        } else {
            $errorDetail = new ErrorDetailDTO('An unexpected error occurred', 500);
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($errorDetail->getStatusCode());
        $response->setContent(json_encode($errorDetail->toArray()));

        $event->setResponse($response);
    }

    private function createValidationErrorDetail(
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