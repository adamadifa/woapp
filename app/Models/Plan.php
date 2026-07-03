<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'max_projects',
        'max_team_members',
        'has_custom_landing',
        'has_client_dashboard',
        'features',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'max_projects' => 'integer',
        'max_team_members' => 'integer',
        'has_custom_landing' => 'boolean',
        'has_client_dashboard' => 'boolean',
        'features' => 'array',
    ];
}
