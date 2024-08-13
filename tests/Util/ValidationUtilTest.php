<?php

namespace App\Tests\Util;

use App\Util\ValidationUtil;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationUtilTest extends TestCase
{

    public function testCreateValidationErrorDetail()
    {
        // Simula duas violações de validação
        $violation1 = new ConstraintViolation(
            'Erro no campo 1',      // mensagem
            '',                     // mensagemTemplate
            [],                     // parâmetros
            '',                     // root
            'campo1',               // propertyPath
            ''                      // valor inválido
        );

        $violation2 = new ConstraintViolation(
            'Erro no campo 2',
            '',
            [],
            '',
            'campo2',
            ''
        );

        // Cria uma lista de violações
        $violations = new ConstraintViolationList([$violation1, $violation2]);

        // Cria o ErrorDetailDTO usando o ValidationUtil
        $errorDetail = ValidationUtil::createValidationErrorDetail($violations, 'Erro de validação', 400);

        // Assegura que a mensagem e o status code estão corretos
        $this->assertEquals('Erro de validação', $errorDetail->getMessage());
        $this->assertEquals(400, $errorDetail->getStatusCode());

        // Assegura que os erros de validação foram adicionados corretamente
        $validationErrors = $errorDetail->getValidationErrors();
        $this->assertCount(2, $validationErrors);
        $this->assertArrayHasKey('campo1', $validationErrors);
        $this->assertEquals('Erro no campo 1', $validationErrors['campo1'][0]);
        $this->assertArrayHasKey('campo2', $validationErrors);
        $this->assertEquals('Erro no campo 2', $validationErrors['campo2'][0]);
    }

}