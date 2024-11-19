<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TypeProduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'type_products';

    public function products(): HasOne
    {
        return $this->hasOne(Product::class, 'type_product_id');
    }
}
