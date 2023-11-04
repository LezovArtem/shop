<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\DTO\Factories\CategoryDtoFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController extends Controller
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->getAll();

        return response()->json(CategoryResource::collection($categories), Response::HTTP_OK);
    }

    public function store(StoreCategoryRequest $request, CategoryDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request->validated());

        $category = Category::create($dto->title);

        return response()->json(new CategoryResource($category), Response::HTTP_CREATED);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json(new CategoryResource($category), Response::HTTP_OK);
    }

    public function update(UpdateCategoryRequest $request, Category $category, CategoryDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request->validated());

        $category->update([$dto->title]);

        return response()->json($this->show($category), Response::HTTP_OK);
    }

    public function destroy(Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }
}
