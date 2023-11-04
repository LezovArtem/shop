<?php

declare(strict_types=1);

namespace App\DTO\Factories;

use App\DTO\TagDto;

final class TagDtoFactory
{
    public function createFromRequest($request): TagDto
    {
        return self::createFromArray($request->all());
    }

    private function createFromArray(array $data): TagDto
    {
        $dto = new TagDto();

        $dto->title = $data['title'];

        return $dto;
    }
}
