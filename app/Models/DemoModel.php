<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemoModel extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['first_name', 'last_name', 'message'];
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'city',
        'the_cycle',
        'favorites_days',
        'favorites_time',
        'age',
        'student_gender',
        'teacher_gender',
        'message',
    ];
}
