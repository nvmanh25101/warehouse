<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'unit',
        'quantity',
        'image',
        'supplier_id',
        'note',
    ];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function receipts(): BelongsToMany
    {
        return $this->belongsToMany(Receipt::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
