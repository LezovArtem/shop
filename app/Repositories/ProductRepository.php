<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

final class ProductRepository
{
    public function getAll(): LengthAwarePaginator
    {
        $products = Product::paginate();

        return $products;
    }

    public function withQueryItems($queryItems): LengthAwarePaginator
    {
        $products = Product::where($queryItems)->paginate();

        return $products;
    }

    public function store($dto, $tagIds, $colorIds, $categoryId): Product
    {
       $product = Product::create([
           'title' => $dto->title,
           'description' => $dto->description,
           'quantity' => $dto->quantity,
           'price' => $dto->price,
           'category_id' => $categoryId,
       ]);

       $product->tags()->attach($tagIds);
       $product->colors()->attach($colorIds);

       return $product;
    }


    public function update($product, $dto, $tagIds, $colorIds, $categoryId): Product
    {
        $product->update([
            'title' => $dto->title,
            'description' => $dto->description,
            'quantity' => $dto->quantity,
            'price' => $dto->price,
            'category_id' => $categoryId,
        ]);

        $product->tags()->sync($tagIds);
        $product->colors()->sync($colorIds);

        return $product->fresh();
    }
}
