<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Export extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'note',
        'user_id',
        'export_date',
        'customer_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class)
            ->withPivot('quantity');
    }

    public function getUserNameAttribute(): string
    {
        return $this->user->name;
    }

    public function getCustomerNameAttribute(): string
    {
        return $this->customer->name;
    }
}
