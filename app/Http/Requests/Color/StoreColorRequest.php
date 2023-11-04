<?php

declare(strict_types=1);

namespace App\Http\Requests\Color;

use Illuminate\Foundation\Http\FormRequest;

final class StoreColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string']
        ];
    }
}
