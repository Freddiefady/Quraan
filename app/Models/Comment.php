<?php

namespace App\Models;

use App\Models\User;
use App\Models\Rating;
use App\Models\Articles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['comment', 'user_id', 'status', 'rating_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function article()
    {
        return $this->belongsTo(Articles::class, 'article_id');
    }
    public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id');
    }
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
