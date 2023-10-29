<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class ProductColor extends Model
{
    use HasFactory;
    protected $table = 'product_color';
    protected $fillable = [
        'product_id',
        'color_id'
    ];
}
