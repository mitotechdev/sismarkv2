<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'targets';

    public function sales(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function market_progress(): BelongsTo
    {
        return $this->belongsTo(MarketProgress::class, 'market_progress_id', 'id');
    }
}
