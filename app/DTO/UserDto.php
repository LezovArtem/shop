<?php

declare(strict_types=1);

namespace App\DTO;

final class UserDto
{
    public string $id;
    public string $role;
    public string $first_name;
    public string $middle_name;
    public string $last_name;
    public int $gender;
    public string $address;
    public string $email;
}
