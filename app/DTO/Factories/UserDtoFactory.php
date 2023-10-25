<?php

declare(strict_types=1);

namespace App\DTO\Factories;

use App\DTO\UserDto;

final class UserDtoFactory
{
    public function createFromRequest($request): UserDto
    {
        return self::createFromArray($request->all());
    }

    private function createFromArray(array $data): UserDto
    {
        $dto = new UserDto();

        $dto->name = $data['name'];
        $dto->first_name = $data['first_name'];
        $dto->middle_name = $data['middle_name'];
        $dto->last_name = $data['last_name'];
        $dto->gender = $data['gender'];
        $dto->address = $data['address'];
        $dto->email = $data['email'];

        return $dto;
    }
}
