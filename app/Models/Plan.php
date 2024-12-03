<?php

namespace App\Models;

use App\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sessions_per_week', 'session_duration', 'price', 'has_trial_lesson'
    ];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
