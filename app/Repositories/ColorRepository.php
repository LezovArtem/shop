<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Collection;

final class ColorRepository
{
    public function getAll(): Collection
    {
        $colors = Color::all();

        return $colors;
    }
}
