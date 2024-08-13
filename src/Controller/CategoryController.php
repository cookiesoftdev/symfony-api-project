<?php

namespace App\Controller;

use App\Converter\CategoryDTOConverter;
use App\Dto\CategoryDTO;
use App\Entity\Category;
use App\Exception\ValidationException;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/category', name: 'app_category_')]
class CategoryController extends AbstractController
{
    private CategoryService $categoryService;

    private SerializerInterface $serializer;

    private CategoryDTOConverter $categoryDTOConverter;

    private ValidatorInterface $validator;

    public function __construct(CategoryService $categoryService,
                                SerializerInterface $serializer,
                                CategoryDTOConverter $categoryDTOConverter,
                ValidatorInterface $validator)
    {
        $this->categoryService = $categoryService;
        $this->serializer = $serializer;
        $this->categoryDTOConverter = $categoryDTOConverter;
        $this->validator = $validator;
    }

    #[Route('', name: 'getAll', methods: ['GET'])]
    public function listCategories(): JsonResponse
    {
        $categories = $this->categoryService->getAll();

        $categoriesDTOs = $this->categoryDTOConverter->convertToDTOList($categories);

        return $this->json($categoriesDTOs);
    }

    #[Route('/{id}', name: 'getOne', methods: ['GET'])]
    public function getCategory(int $id): JsonResponse
    {
        $category = $this->categoryService->getOne($id);

        $categoryDTO = $this->categoryDTOConverter->convertToDTO($category);

        return $this->json($categoryDTO);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function createCategory(Request $request): JsonResponse
    {
        $categoryDTO = $this->serializer->deserialize($request->getContent(), CategoryDTO::class, 'json');

        $errors = $this->validator->validate($categoryDTO);

        if (count($errors) > 0) {
            throw new ValidationException($errors, Response::HTTP_BAD_REQUEST);
        }

        $category = new Category();
        $category->setName($categoryDTO->getName());
        $category->setDescription($categoryDTO->getDescription());
        $category->setPicture($categoryDTO->getPicture());
        $category->setStatus($categoryDTO->getStatus());

        $this->categoryService->create($category);

        return new JsonResponse(null, Response::HTTP_CREATED);

    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function updateCategory(Request $request, int $id): JsonResponse
    {
        $categoryDTO = $this->serializer->deserialize($request->getContent(), CategoryDTO::class, 'json');

        $errors = $this->validator->validate($categoryDTO);

        if (count($errors) > 0) {
            throw new ValidationException($errors, Response::HTTP_BAD_REQUEST);
        }

        $category = new Category();
        $category->setName($categoryDTO->getName());
        $category->setDescription($categoryDTO->getDescription());
        $category->setPicture($categoryDTO->getPicture());
        $category->setStatus($categoryDTO->getStatus());

        $this->categoryService->update($category, $id);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteCategory(int $id): JsonResponse
    {
        $this->categoryService->delete($id);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
