<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'body'];
    protected $fillable = ['name', 'email', 'phone', 'body'];
}
