<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Comment;
use App\Models\Articles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'status',
    ];

    public function article()
    {
        return $this->hasMany(Articles::class, 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function status()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    // public function courses()
    // {
    //     return $this->hasMany(Course::class, 'user_id');
    // }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Summary of casts
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'=>'hashed'
    ];
}
