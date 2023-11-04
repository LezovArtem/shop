<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

final class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() != null && $this->user()->tokenCan('create');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'category' => ['array'],
            'tags' => ['array'],
            'colors' => ['array']
        ];
    }
}
