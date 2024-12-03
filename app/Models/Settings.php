<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_name',
        'favicon',
        'logo',
        'email',
        'facebook',
        'whatsapp',
        'youtube',
        'location',
        'phone',
        'small_description',
    ];
}