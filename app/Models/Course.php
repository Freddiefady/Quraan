<?php

namespace App\Models;

use App\Models\User;
use App\Models\Video;
use App\Models\Sheikhs;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, Sluggable, HasTranslations;
    public $translatable = ['title', 'description'];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'user_id',
        'sheikh_id',
        'admin_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function sheikh()
    {
        return $this->belongsTo(Sheikhs::class, 'sheikh_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'admin_id');
    }
    public function videos()
    {
        return $this->hasMany(Video::class, 'course_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
