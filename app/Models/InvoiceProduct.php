<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class InvoiceProduct extends Model
{
    use HasFactory;
    protected $table = 'invoice_products';
    protected $fillable = [
        'product_id',
        'invoice_id'
    ];
}
