<?php

declare(strict_types=1);

namespace App\DTO\Factories;

use App\DTO\ProductDto;

final class ProductDtoFactory
{
    public function createFromRequest($request): ProductDto
    {
        return self::createFromArray($request->all());
    }

    private function createFromArray(array $data): ProductDto
    {
        $dto = new ProductDto();

        $dto->title = $data['title'];
        $dto->description = $data['description'];
        $dto->quantity = $data['quantity'];
        $dto->price = $data['price'];
        $dto->category = $data['category'];
        $dto->tags = $data['tags'];
        $dto->colors = $data['colors'];

        return $dto;
    }
}
