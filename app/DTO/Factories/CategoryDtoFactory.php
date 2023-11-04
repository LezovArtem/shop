<?php

declare(strict_types=1);

namespace App\DTO\Factories;

use App\DTO\CategoryDto;

final class CategoryDtoFactory
{
    public function createFromRequest($request): CategoryDto
    {
        return self::createFromArray($request->all());
    }

    private function createFromArray(array $data): CategoryDto
    {
        $dto = new CategoryDto();

        $dto->title = $data['title'];

        return $dto;
    }
}
