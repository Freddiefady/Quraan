<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheikhs extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'age',
        'gender',
        'level_of_english',
        'vacation',
        'education',
        'time_available',
        'studies',
        'links',
        'cv',
        'recommendations',
        'title',
        'description',
        'experience',
    ];
    public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id');
    }
    public function courses()
    {
        return $this->hasMany(Course::class, 'sheikh_id');
    }
}
