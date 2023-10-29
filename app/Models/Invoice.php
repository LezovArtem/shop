<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Invoice extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'invoices';
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'billed_date',
        'paid_date',
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'invoice_products', 'invoice_id', 'product_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
