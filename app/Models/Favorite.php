<?php

namespace App\Models;

use App\Models\User;
use App\Models\Audio;
use App\Models\Sheikhs;
use App\Models\Articles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'article_id',
        'sheikhs_id',
        'audio_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function article()
    {
        return $this->belongsTo(Articles::class, 'article_id');
    }
    public function audio()
    {
        return $this->belongsTo(Audio::class, 'audio_id');
    }
    public function sheikh()
    {
        return $this->belongsTo(Sheikhs::class,'sheikhs_id');
    }
}
