<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory; //menambahkan soft deletes
    protected $guarded = ['id'];
    protected $tables = 'customers';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function workplans(): HasMany
    {
        return $this->hasMany(Workplan::class, 'customer_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function sales_order(): HasMany
    {
        return $this->hasMany(SalesOrder::class, 'customer_id', 'id');
    }

    public function category_customer(): BelongsTo
    {
        return $this->belongsTo(CategoryCustomer::class, 'category_customer_id', 'id');
    }

    public function type_customer(): BelongsTo
    {
        return $this->belongsTo(TypeCustomer::class, 'type_customer_id', 'id');
    }

    public function recap_invoice(): HasMany
    {
        return $this->hasMany(RecapInvoice::class, 'customer_id', 'id');
    }
}
