<?php

namespace App\Converter;

use App\Dto\CategoryDTO;
use App\Entity\Category;

class CategoryDTOConverter
{

    public function convertToDTO(Category $category): CategoryDTO{
        $categoryDTO = new CategoryDTO();
        $categoryDTO->setId($category->getId());
        $categoryDTO->setName($category->getName());
        $categoryDTO->setDescription($category->getDescription());
        $categoryDTO->setPicture($category->getPicture());
        $categoryDTO->setStatus($category->getStatus());
        return $categoryDTO;
    }

    public function convertToDTOList(array $categories): array{
        $categoriesDTO = [];
        foreach($categories as $category){
            $categoriesDTO[] = $this->convertToDTO($category);
        }
        return $categoriesDTO;
    }

}