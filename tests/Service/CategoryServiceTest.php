<?php

namespace App\Tests\Service;

use App\Entity\Category;
use App\Service\CategoryService;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryServiceTest extends KernelTestCase
{

    private $entityManager;
    private $categoryService;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->categoryService = new CategoryService($this->entityManager);
    }

    public function testGetAllCategories()
    {
        // Cria e persiste categorias no banco de dados
        $category1 = new Category();
        $category1->setName('Category 1');
        $category1->setDescription('Description 1');
        $category1->setStatus(1);
        $this->entityManager->persist($category1);

        $category2 = new Category();
        $category2->setName('Category 2');
        $category2->setDescription('Description 2');
        $category2->setStatus(1);
        $this->entityManager->persist($category2);

        $this->entityManager->flush();

        // Testa o serviço
        $categories = $this->categoryService->getAll();

        $this->assertCount(2, $categories);
        $this->assertEquals('Category 1', $categories[0]->getName());
        $this->assertEquals('Category 2', $categories[1]->getName());
    }

    protected function tearDown(): void
    {
        // Limpa a tabela Category após a execução dos testes
        $this->entityManager->createQuery('DELETE FROM App\Entity\Category')->execute();

        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }





}