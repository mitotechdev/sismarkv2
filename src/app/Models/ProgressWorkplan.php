<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressWorkplan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'progress_workplans';
    protected $casts = [
        'date_progress' => 'date',
    ];

    public function workplan(): BelongsTo
    {
        return $this->belongsTo(Workplan::class);
    }

    public function market_progress(): BelongsTo
    {
        return $this->belongsTo(MarketProgress::class, 'market_progress_id');
    }

    public function sales(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
