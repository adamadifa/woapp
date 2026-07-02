<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineTemplate extends Model
{
    protected $fillable = [
        'title',
        'description',
        'days_before_wedding',
        'order',
    ];
}
