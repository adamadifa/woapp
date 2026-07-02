<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RundownItem extends Model
{
    protected $fillable = [
        'project_id',
        'time_start',
        'time_end',
        'activity',
        'pic',
        'notes',
        'order',
    ];

    public function weddingProject(): BelongsTo
    {
        return $this->belongsTo(WeddingProject::class, 'project_id');
    }
}
