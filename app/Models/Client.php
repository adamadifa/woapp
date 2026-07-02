<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use Multitenantable;

    protected $fillable = [
        'wo_profile_id',
        'user_id',
        'groom_name',
        'bride_name',
        'wedding_date',
        'phone',
        'package_id',
    ];

    public function woProfile(): BelongsTo
    {
        return $this->belongsTo(WoProfile::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(WeddingPackage::class, 'package_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(WeddingProject::class);
    }
}
