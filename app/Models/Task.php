<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'milestone_id',
        'title',
        'assigned_to',
        'status',
        'due_date',
    ];

    public function milestone(): BelongsTo
    {
        return $this->belongsTo(ScheduleMilestone::class, 'milestone_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
