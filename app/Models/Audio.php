<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Audio extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['name'];
    protected $fillable = [
        'name',
        'path'
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'audio_id');
    }
}
