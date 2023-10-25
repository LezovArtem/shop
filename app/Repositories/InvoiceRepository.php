<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Diff\Exception;

class InvoiceRepository
{
    public function __construct(private InvoiceService $service)
    {
    }

    public function store($dto, $productIds, $paid_date)
    {
            try {
                DB::beginTransaction();

                $invoice = Invoice::create([
                    'user_id' => $dto->user_id,
                    'amount' => $dto->amount,
                    'status' => $dto->status,
                    'billed_date' => now()->toDateTimeString(),
                    'paid_date' => $paid_date,
                ]);

                $invoice->products()->attach($productIds);

                DB::commit();
            } catch (Exception $exception){
                DB::rollBack();

                return $exception->getMessage();
            }
        return $invoice;
    }

    public function update($invoice, $dto, $productIds)
    {
        try {
            DB::beginTransaction();

            $invoice->update([
                'user_id' => $dto->user_id,
                'amount' => $dto->amount,
                'status' => $dto->status,
                'billed_date' => $dto->billed_date,
                'paid_date' => $dto->paid_date,
            ]);

            $invoice->products()->sync($productIds);

            DB::commit();

        } catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }

        return $invoice->fresh();
    }
}
