<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendor extends Model
{
    protected $fillable = [
        'wo_profile_id',
        'name',
        'category',
        'phone',
        'address',
        'price_range',
        'rating',
        'status',
        'notes',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
    ];

    public function woProfile(): BelongsTo
    {
        return $this->belongsTo(WoProfile::class);
    }
}
