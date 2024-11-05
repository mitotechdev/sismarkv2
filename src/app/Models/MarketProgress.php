<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MarketProgress extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'market_progress';
    
    public function target(): HasOne
    {
        return $this->hasOne(Target::class, 'market_progress_id', 'id');
    }

    public function workplan(): HasOne
    {
        return $this->hasOne(Workplan::class, 'market_progress_id');
    }

    public function progress_workplan(): HasOne
    {
        return $this->hasOne(ProgressWorkplan::class, 'market_progress_id');
    }
}
