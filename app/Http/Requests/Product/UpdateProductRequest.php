<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null && $this->user()->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
