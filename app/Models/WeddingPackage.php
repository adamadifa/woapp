<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingPackage extends Model
{
    protected $fillable = [
        'wo_profile_id',
        'name',
        'description',
        'price',
        'items',
        'images',
        'is_active',
    ];

    protected $casts = [
        'items' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function woProfile(): BelongsTo
    {
        return $this->belongsTo(WoProfile::class);
    }
}
