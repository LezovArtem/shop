<?php

declare(strict_types=1);

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateInvoiceRequest extends FormRequest
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
                'userId' => ['required', 'integer'],
                'amount' => ['required', 'integer'],
                'status' => ['required', Rule::in('B', 'b', 'P', 'p', 'V', 'v')],
                'billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
                'paidDate' => ['date_format:Y-m-d H:i:s'],
                'products' => ['required', 'array']
            ];
    }

    protected function prepareForValidation()
    {
        if ($this->userId){
            $this->merge([
                'user_id' => $this->userId
            ]);
        }

        if ($this->billedDate){
            $this->merge([
                'billed_date' => $this->billedDate
            ]);
        }

        if ($this->paidDate){
            $this->merge([
                'paid_date' => $this->paidDate
            ]);
        }

    }
}
