<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() != null && $this->user()->tokenCan('update');
    }

    public function rules(): array
    {
            return [
                'title' => ['required', 'string'],
                'description' => ['required', 'string'],
                'quantity' => ['required', 'integer'],
                'price' => ['required', 'numeric'],
                'categoryId' => ['integer'],
                'category' => ['array'],
                'tags' => ['array'],
                'colors' => ['array'],
            ];
    }
}
