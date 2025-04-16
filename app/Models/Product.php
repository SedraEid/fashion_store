<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'color',
        'category_id',
        'saller_id',
        'stock_quantity',
        'discounts',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'saller_id');
    }
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
