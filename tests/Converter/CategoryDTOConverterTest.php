<?php

namespace App\Tests\Converter;

use App\Converter\CategoryDTOConverter;
use App\Dto\CategoryDTO;
use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryDTOConverterTest extends TestCase
{

    private $converter;

    protected function setUp(): void
    {
        $this->converter = new CategoryDTOConverter();
    }

    public function testConvertToDTO()
    {
        // Cria um objeto Category fictício
        $category = new Category();
        $category->setName('Category 1');
        $category->setDescription('Description 1');
        $category->setPicture('picture1.jpg');
        $category->setStatus(1);

        // Converte para CategoryDTO
        $categoryDTO = $this->converter->convertToDTO($category);

        // Verifica se os valores foram corretamente atribuídos
        $this->assertInstanceOf(CategoryDTO::class, $categoryDTO);
        $this->assertEquals('Category 1', $categoryDTO->getName());
        $this->assertEquals('Description 1', $categoryDTO->getDescription());
        $this->assertEquals('picture1.jpg', $categoryDTO->getPicture());
        $this->assertEquals(1, $categoryDTO->getStatus());
    }

    public function testConvertToDTOList()
    {
        // Cria um array de objetos Category fictícios
        $category1 = new Category();
        $category1->setName('Category 1');
        $category1->setDescription('Description 1');
        $category1->setPicture('picture1.jpg');
        $category1->setStatus(1);

        $category2 = new Category();
        $category2->setName('Category 2');
        $category2->setDescription('Description 2');
        $category2->setPicture('picture2.jpg');
        $category2->setStatus(0);

        $categories = [$category1, $category2];

        // Converte para uma lista de CategoryDTO
        $categoriesDTO = $this->converter->convertToDTOList($categories);

        // Verifica se a lista contém a quantidade correta de itens
        $this->assertCount(2, $categoriesDTO);

        // Verifica o conteúdo do primeiro CategoryDTO
        $this->assertInstanceOf(CategoryDTO::class, $categoriesDTO[0]);
        $this->assertEquals('Category 1', $categoriesDTO[0]->getName());
        $this->assertEquals('Description 1', $categoriesDTO[0]->getDescription());
        $this->assertEquals('picture1.jpg', $categoriesDTO[0]->getPicture());
        $this->assertEquals(1, $categoriesDTO[0]->getStatus());

        // Verifica o conteúdo do segundo CategoryDTO
        $this->assertInstanceOf(CategoryDTO::class, $categoriesDTO[1]);
        $this->assertEquals('Category 2', $categoriesDTO[1]->getName());
        $this->assertEquals('Description 2', $categoriesDTO[1]->getDescription());
        $this->assertEquals('picture2.jpg', $categoriesDTO[1]->getPicture());
        $this->assertEquals(0, $categoriesDTO[1]->getStatus());
    }


}