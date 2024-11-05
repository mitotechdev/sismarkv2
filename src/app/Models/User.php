<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    protected $tables = 'users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function customer(): HasMany
    {
        return $this->hasMany(Customer::class, 'user_id', 'id');
    }

    public function target(): HasOne
    {
        return $this->hasOne(Target::class, 'sales_id', 'id');
    }
    
    public function workplans()
    {
        return $this->hasMany(Workplan::class, 'sales_id');
    }

    public function sales_order(): HasMany
    {
        return $this->hasMany(SalesOrder::class, 'sales_id');
    }

    public function progress_workplan(): HasMany
    {
        return $this->hasMany(ProgressWorkplan::class, 'user_id');
    }
}
