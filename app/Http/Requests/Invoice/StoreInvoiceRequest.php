<?php

declare(strict_types=1);

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() != null && $this->user()->tokenCan('create');
    }

    public function rules(): array
    {
        return [
            'userId' => ['required', 'integer'],
            'amount' => ['required', 'integer'],
            'status' => ['required', Rule::in('B', 'b', 'P', 'p', 'V', 'v')],
            'billedDate' => ['date_format:Y-m-d H:i:s'],
            'paidDate' => ['date_format:Y-m-d H:i:s'],
            'products' => ['required', 'array']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->userId,
            'billed_date' => $this->billedDate,
            'paid_date' => $this->paidDate,
        ]);
    }
}
