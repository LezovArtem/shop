<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    public function store($dto)
    {
        $user = User::create([
            'role' => $dto->name,
            'first_name' => $dto->first_name,
            'middle_name' => $dto->middle_name,
            'last_name' => $dto->last_name,
            'gender' => $dto->gender,
            'address' => $dto->address,
            'email' => $dto->email,
            'password' => rand(),
        ]);

        return $user;
    }

    public function update($user, $dto)
    {
        $user->update([
            'name' => $dto->name,
            'first_name' => $dto->first_name,
            'middle_name' => $dto->middle_name,
            'last_name' => $dto->last_name,
            'gender' => $dto->gender,
            'address' => $dto->address,
            'email' => $dto->email
        ]);

        return $user;
    }

}
