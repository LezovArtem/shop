<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() != null && $this->user()->tokenCan('update');
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

    public function prepareForValidation()
    {
        if ($this->firstName){
            $this->merge([
                'first_name' => $this->firstName,
            ]);
        }
        if ($this->middleName){
            $this->merge([
                'middle_name' => $this->middleName,
            ]);
        }
        if ($this->lastName){
            $this->merge([
                'last_name' => $this->lastName,
            ]);
        }

    }
}
