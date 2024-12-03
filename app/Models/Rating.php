<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Sheikhs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['rating', 'sheikhs_id'];
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'rating_id');
    }
    public function article()
    {
        return $this->belongsTo(Rating::class, 'rating_id');
    }

}
