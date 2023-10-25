<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

class ProductRepository
{

    public function store($dto, $tagIds, $colorIds, $categoryId)
    {
        try {
            DB::beginTransaction();

            $product = Product::create([
                'title' => $dto->title,
                'description' => $dto->description,
                'quantity' => $dto->quantity,
                'price' => $dto->price,
                'category_id' => $categoryId,
            ]);

            $product->tags()->attach($tagIds);
            $product->colors()->attach($colorIds);

            DB::commit();
        } catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }

        return $product;
    }


    public function update($product, $dto, $tagIds, $colorIds, $categoryId)
    {
        try {
            DB::beginTransaction();

            $product->update([
                'title' => $dto->title,
                'description' => $dto->description,
                'quantity' => $dto->quantity,
                'price' => $dto->price,
                'category_id' => $categoryId,
            ]);

            $product->tags()->sync($tagIds);
            $product->colors()->sync($colorIds);

            DB::commit();

        } catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }

        return $product->fresh();
    }
}
