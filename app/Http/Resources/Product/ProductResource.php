<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Http\Resources\Color\ColorResource;
use App\Http\Resources\Tag\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'title' => $this->title,
          'description' => $this->description,
          'quantity' => $this->quantity,
          'price' => $this->price,
          'categoryId' => $this->category_id,
          'tags' => TagResource::collection($this->tags),
          'colors' => ColorResource::collection($this->colors),
        ];
    }
}
