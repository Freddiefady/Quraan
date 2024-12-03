<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'read_id'];

    public function read(){
        return $this->belongsTo(Reads::class, 'read_id');
    }
}