<?php

declare(strict_types=1);

namespace App\DTO\Factories;

use App\DTO\InvoiceDto;

final class InvoiceDtoFactory
{
    public function createFromRequest($request): InvoiceDto
    {
        return self::createFromArray($request->all());
    }

    private function createFromArray(array $data): InvoiceDto
    {
        $dto = new InvoiceDto();

        $dto->user_id = $data['user_id'];
        $dto->amount = $data['amount'];
        $dto->status = $data['status'];
        $dto->billed_date = $data['billed_date'];
        $dto->paid_date = $data['paid_date'];
        $dto->products = $data['products'];

        return $dto;
    }
}
