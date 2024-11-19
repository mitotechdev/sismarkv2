<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecapInvoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $tables = 'recap_invoices';
    protected $casts = [
        'date_invoice' => 'date',
        'due_date' => 'date',
        'date_payment' => 'date',
    ];

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
