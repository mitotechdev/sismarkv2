<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CategoryCustomer extends Model
{
    use HasFactory;
    protected $table = 'category_customers';
    protected $guarded = ['id'];

    public function customers()
    {
        return $this->hasOne(Customer::class, 'category_customer_id', 'id');
    }

    public function workplan(): HasOne
    {
        return $this->hasOne(Workplan::class, 'category_customer_id');
    }

    public function sales_order(): HasOne
    {
        return $this->hasOne(SalesOrder::class, 'segmen_id');
    }

}
