<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'course_id'];

    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
}
