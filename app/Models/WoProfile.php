<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WoProfile extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'slug',
        'logo',
        'description',
        'phone',
        'address',
        'subscription_plan',
        'expired_at',
        'landing_settings',
    ];

    protected $casts = [
        'landing_settings' => 'array',
        'expired_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(WeddingPackage::class);
    }

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function venues(): HasMany
    {
        return $this->hasMany(Venue::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(WeddingProject::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(WoInquiry::class, 'wo_profile_id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'wo_profile_id');
    }
}
