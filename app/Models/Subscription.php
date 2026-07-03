<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'wo_profile_id',
        'plan',
        'amount',
        'payment_method',
        'payment_proof',
        'status',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function woProfile(): BelongsTo
    {
        return $this->belongsTo(WoProfile::class, 'wo_profile_id');
    }
}
