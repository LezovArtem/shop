<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

final class CategoryRepository
{
    public function getAll(): Collection
    {
        $categories = Category::all();

        return $categories;
    }
}
