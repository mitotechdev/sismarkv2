<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Approval extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'approvals';

    public function sales_order(): HasOne
    {
        return $this->hasOne(SalesOrder::class, 'approval_id', 'id');
    }
}
