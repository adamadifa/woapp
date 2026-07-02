<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectChecklist extends Model
{
    protected $table = 'project_checklists';

    protected $fillable = [
        'project_id',
        'name',
        'category',
        'status',
        'due_date',
    ];

    public function weddingProject(): BelongsTo
    {
        return $this->belongsTo(WeddingProject::class, 'project_id');
    }
}
