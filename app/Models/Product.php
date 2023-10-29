<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
      'title',
      'description',
      'quantity',
      'price',
      'category_id',
    ];

    public function invoices(){
        return $this->belongsToMany(Invoice::class, 'invoice_products', 'product_id', 'invoice_id');
    }

    public function colors(){
        return $this->belongsToMany(Color::class, 'product_colors', 'product_id', 'color_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id');
    }
}
