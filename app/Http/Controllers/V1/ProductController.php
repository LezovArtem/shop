<?php

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

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProductFilter();
        $queryItems = $filter->transform($request);

        if (empty($queryItems)){
            return ProductResource::collection(Product::paginate());
        } else {
            $products = Product::where($queryItems)->paginate();

            return ProductResource::collection($products->appends($request->query()));
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
    public function show(Product $product)
    {
        return new ProductResource($product);
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
    public function destroy(Product $product)
    {
        $product->delete();
    }
}
