<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesOrder extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'sales_orders';

    protected $casts = [
        'order_date' => 'date',
        'term_of_payment' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function segmen(): BelongsTo
    {
        return $this->belongsTo(CategoryCustomer::class, 'segmen_id', 'id');
    }

    public function approval(): BelongsTo
    {
        return $this->belongsTo(Approval::class, 'approval_id', 'id');
    }

    public function sales_order_items(): HasMany
    {
        return $this->hasMany(SalesOrderItem::class, 'sales_order_id');
    }
    
    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class, 'tax_id', 'id');
    }

    public function sales(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_id', 'id');
    }   
}
