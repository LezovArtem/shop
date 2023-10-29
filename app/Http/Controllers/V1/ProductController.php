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
use App\Services\ProductService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $filter = new ProductFilter();
        $queryItems = $filter->transform($request);

        if (empty($queryItems)){
            return response()->json(ProductResource::collection(Product::paginate()), Response::HTTP_OK);
        } else {
            $products = Product::where($queryItems)->paginate();

            return response()->json(ProductResource::collection($products->appends($request->query())), Response::HTTP_OK);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, ProductDtoFactory $dtoFactory)
    {
        $dto = $dtoFactory->createFromRequest($request);

        $product = $this->productService->store($dto);

        return $product instanceof Product ? new ProductResource($product) : $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json(new ProductResource($product), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product, ProductDtoFactory $dtoFactory)
    {
        $dto = $dtoFactory->createFromRequest($request);

        $product = $this->productService->update($product, $dto);

        return $product instanceof Product ? new ProductResource($product) : $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): Response
    {
        $product->delete();
        return response()->noContent();
    }
}
