<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'products';

    public function sales_order_item(): BelongsTo
    {
        return $this->belongsTo(SalesOrderItem::class);
    }

    public function pricelist(): HasMany
    {
        return $this->hasMany(Pricelist::class, 'product_id');
    }
}
