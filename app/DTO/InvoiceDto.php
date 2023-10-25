<?php

declare(strict_types=1);

namespace App\DTO;

final class InvoiceDto
{
    public int $user_id;
    public int $amount;
    public string $status;
    public ?string $billed_date;
    public ?string $paid_date;
    public array $products;
}
