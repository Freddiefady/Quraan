<?php

namespace App\Models;

use App\Models\Articles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'articles_id',
        'user_id',
    ];

    public function article()
    {
        return $this->belongsTo(Articles::class, 'articles_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
