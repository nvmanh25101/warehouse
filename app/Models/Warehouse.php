<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'threshold',
        'product_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function exports(): BelongsToMany
    {
        return $this->belongsToMany(Export::class)
            ->withPivot('quantity');
    }

    public function getWarningAttribute(): bool
    {
        return $this->quantity < $this->threshold;
    }
}
