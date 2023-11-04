<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Invoice;
use Illuminate\Pagination\LengthAwarePaginator;

final class InvoiceRepository
{
    public function getAll(): LengthAwarePaginator
    {
        $invoices = Invoice::paginate();

        return $invoices;
    }

    public function withQueryItems($queryItems): LengthAwarePaginator
    {
        $invoices = Invoice::where($queryItems)->paginate();

        return $invoices;
    }

    public function store($dto, $productIds, $paid_date): Invoice
    {

        $invoice = Invoice::create([
            'user_id' => $dto->user_id,
            'amount' => $dto->amount,
            'status' => $dto->status,
            'billed_date' => now()->toDateTimeString(),
            'paid_date' => $paid_date,
        ]);

        $invoice->products()->attach($productIds);

        return $invoice;
    }

    public function update($invoice, $dto, $productIds): Invoice
    {
        $invoice->update([
            'user_id' => $dto->user_id,
            'amount' => $dto->amount,
            'status' => $dto->status,
            'billed_date' => $dto->billed_date,
            'paid_date' => $dto->paid_date,
        ]);

        $invoice->products()->sync($productIds);

        return $invoice->fresh();
    }
}
