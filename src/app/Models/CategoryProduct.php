<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'category_products';

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'category_product_id');
    }
}
