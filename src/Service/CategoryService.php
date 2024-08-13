<?php

namespace App\Service;

use App\Entity\Category;
use App\Exception\EntityNotFoundException;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    private EntityManagerInterface $entityManager;
    private CategoryRepository $categoryRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $entityManager->getRepository(Category::class);
    }

    public function getAll(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getOne(int $id): ?Category
    {

        $category = $this->categoryRepository->find($id);

        if($category === null) {
            throw new EntityNotFoundException(sprintf('Category with id %d not found', $id));
        }

        return $this->categoryRepository->find($id);
    }

    public function create(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function update(Category $category, int $id): void
    {
        $categoryFind = $this->getOne($id);

        $categoryFind->setName($category->getName());
        $categoryFind->setDescription($category->getDescription());
        $categoryFind->setPicture($category->getPicture());
        $categoryFind->setStatus($category->getStatus());

        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $categoryFind = $this->getOne($id);

        $this->entityManager->remove($categoryFind);
        $this->entityManager->flush();
    }
}