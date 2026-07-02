<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeddingProject extends Model
{
    use Multitenantable;

    protected $fillable = [
        'client_id',
        'wo_profile_id',
        'name',
        'wedding_date',
        'venue_id',
        'total_budget',
        'status',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function woProfile(): BelongsTo
    {
        return $this->belongsTo(WoProfile::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function budgetItems(): HasMany
    {
        return $this->hasMany(BudgetItem::class, 'project_id');
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(ScheduleMilestone::class, 'project_id');
    }

    public function guestList(): HasMany
    {
        return $this->hasMany(GuestList::class, 'project_id');
    }

    public function rundownItems(): HasMany
    {
        return $this->hasMany(RundownItem::class, 'project_id');
    }

    public function checklists(): HasMany
    {
        return $this->hasMany(ProjectChecklist::class, 'project_id');
    }

    public function clientNotes(): HasMany
    {
        return $this->hasMany(ClientNote::class, 'project_id');
    }
}
