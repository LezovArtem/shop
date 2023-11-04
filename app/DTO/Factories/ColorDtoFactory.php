<?php

declare(strict_types=1);

namespace App\DTO\Factories;

use App\DTO\ColorDto;

final class ColorDtoFactory
{
    public function createFromRequest($request): ColorDto
    {
        return self::createFromArray($request->all());
    }

    private function createFromArray(array $data): ColorDto
    {
        $dto = new ColorDto();

        $dto->title = $data['title'];

        return $dto;
    }
}
