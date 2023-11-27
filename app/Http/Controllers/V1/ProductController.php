<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\DTO\Factories\ProductDtoFactory;
use App\Filters\V1\ProductFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductController extends Controller
{
    public function __construct(private ProductService $productService, private ProductRepository $productRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $filter = new ProductFilter();
        $queryItems = $filter->transform($request);

        $products = $this->productRepository->getAll();

        if (empty($queryItems)){
            return response()->json(ProductResource::collection($products), Response::HTTP_OK);
        } else {
            $products = $this->productRepository->withQueryItems($queryItems);

            return response()->json(ProductResource::collection($products->appends($request->query())), Response::HTTP_OK);
        }
    }

    public function store(StoreProductRequest $request, ProductDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request);

        try {
            $product = $this->productService->store($dto);
        } catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }

        return response()->json(new ProductResource($product), Response::HTTP_CREATED);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json(new ProductResource($product), Response::HTTP_OK);
    }

    public function update(UpdateProductRequest $request, Product $product, ProductDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request);

        try {
            $product = $this->productService->update($product, $dto);
        } catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }

        return response()->json(new ProductResource($product), Response::HTTP_OK);
    }

    public function destroy(Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
