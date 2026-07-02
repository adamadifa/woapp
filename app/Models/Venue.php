<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venue extends Model
{
    use Multitenantable;

    protected $fillable = [
        'wo_profile_id',
        'name',
        'address',
        'capacity',
        'facilities',
        'price',
        'contact_phone',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
        'facilities' => 'array',
        'price' => 'decimal:2',
    ];

    public function woProfile(): BelongsTo
    {
        return $this->belongsTo(WoProfile::class);
    }

    public function weddingProjects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WeddingProject::class);
    }
}
