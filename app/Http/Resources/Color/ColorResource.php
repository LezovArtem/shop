<?php

declare(strict_types=1);

namespace App\Http\Resources\Color;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ColorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title
        ];
    }
}
