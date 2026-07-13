<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendor extends Model
{
    use Multitenantable;

    protected $fillable = [
        'wo_profile_id',
        'name',
        'category',
        'phone',
        'address',
        'price',
        'rating',
        'status',
        'notes',
        'packages',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'packages' => 'array',
    ];

    public function woProfile(): BelongsTo
    {
        return $this->belongsTo(WoProfile::class);
    }
}
