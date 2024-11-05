<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $tables = 'branches';

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'branch_id', 'id');
    }
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'branch_id', 'id');
    }

    public function target(): HasOne
    {
        return $this->hasOne(Target::class, 'branch_id', 'id');
    }
}
