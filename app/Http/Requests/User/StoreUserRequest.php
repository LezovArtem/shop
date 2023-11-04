<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

final class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() != null && $this->user()->tokenCan('create');
    }

    public function rules(): array
    {
        return [
            'firstName' => ['required', 'string'],
            'middleName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'gender' => ['required', 'integer'],
            'address' => ['required', 'string'],
            'email' => ['required', 'email'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'first_name' => $this->firstName,
            'middle_name' => $this->middleName,
            'last_name' => $this->lastName,
        ]);
    }
}
