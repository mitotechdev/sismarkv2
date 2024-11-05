<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TypeCustomer extends Model
{
    use HasFactory;
    protected $guarded =  ['id'];
    protected $tables = 'type_customers';

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'type_customer_id', 'id');
    }
}
