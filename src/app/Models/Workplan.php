<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workplan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'workplans';

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function market_progress(): BelongsTo
    {
        return $this->belongsTo(MarketProgress::class, 'market_progress_id');
    }

    public function progress_workplan(): HasMany
    {
        return $this->hasMany(ProgressWorkplan::class, 'workplan_id');
    }

    public function category_customer(): BelongsTo
    {
        return $this->belongsTo(CategoryCustomer::class, 'category_customer_id');
    }
}
