<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

final class TagRepository
{
    public function getAll(): Collection
    {
        $tags = Tag::all();

        return $tags;
    }
}
