<?php

namespace App\Tests\Repository;

use App\Entity\Category;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryRepositoryTest extends KernelTestCase
{

    private $entityManager;

    protected function setUp(): void
    {
        // Inicializa o kernel Symfony
        $kernel = self::bootKernel();

        // Obtém o EntityManager do container de serviços
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        // Executa as migrações automaticamente
        //$this->migrateSchema();
    }

    private function migrateSchema(): void
    {
        // Obtenha as metadados das entidades para migrar o esquema
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        // Cria o esquema com base nos metadados
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->createSchema($metadata);
    }


    public function testFindAll()
    {
        $repository = $this->entityManager->getRepository(Category::class);

        // Insere uma categoria de teste
        $category = new Category();
        $category->setName('Test Category');
        $category->setDescription('Test Description');
        $category->setPicture('test.jpg');
        $category->setStatus(1);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        // Testa o método findAll
        $categories = $repository->findAll();
        $this->assertGreaterThanOrEqual(1, count($categories));
    }

    protected function tearDown(): void
    {
        // Limpa a tabela Category após a execução dos testes
        $this->entityManager->createQuery('DELETE FROM App\Entity\Category')->execute();

        // Limpa o EntityManager
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null; // Evita memory leaks
    }

}