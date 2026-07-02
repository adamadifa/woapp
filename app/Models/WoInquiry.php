<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WoInquiry extends Model
{
    protected $table = 'wo_inquiries';

    protected $fillable = [
        'wo_profile_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
    ];

    public function woProfile(): BelongsTo
    {
        return $this->belongsTo(WoProfile::class, 'wo_profile_id');
    }
}
