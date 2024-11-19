<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'products';

    public function sales_order_item(): BelongsTo
    {
        return $this->belongsTo(SalesOrderItem::class);
    }

    public function category_product(): BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class, 'category_product_id');
    }

    // jenis produk
    public function type_product(): BelongsTo
    {
        return $this->belongsTo(TypeProduct::class, 'type_product_id');
    }
}
