<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class ProductTag extends Model
{
    use HasFactory;
    protected $table = 'product_tag';
    protected $fillable = [
        'product_id',
        'tag_id'
    ];
}
