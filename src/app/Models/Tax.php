<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tax extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $tables = 'taxes';

    public function sales_order(): HasOne
    {
        return $this->hasOne(SalesOrder::class, 'tax_id', 'id');
    }

    public function pricelist(): HasOne
    {
        return $this->hasOne(Pricelist::class, 'tax_id', 'id');
    }   
}
