<?php

namespace App\Models;

use App\Models\User;
use App\Models\Admin;
use App\Models\Image;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Articles extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = [
        'title',
        'slug',
        'status',
        'content',
        'satisfied',
        'rating_id',
        // 'user_id',
        'admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function rate()
    {
        return $this->belongsTo(Rating::class, 'rating_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'articles_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
    public function scopeActiveUser($query)
    {

        $query->where(function ($query)
        {
            $query->whereHas('user', function($user){
                $user->whereStatus(1);
            })->orWhere('user_id', null);
        });
    }
    public function status()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }

}
