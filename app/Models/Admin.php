<?php

namespace App\Models;

use App\Models\Roles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'username',
        'status',
        'role_id',
        'email',
        'password'
    ];

    public function posts()
    {
        return $this->hasMany(Articles::class, 'admin_id');
    }
    public function courses(){
        return $this->hasMany(Course::class, 'admin_id');
    }
    public function status()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
    public function hasAccess($config_permission)
    {
        $authorizations = $this->role;

        if(!$authorizations)
        {
            return false;
        }

        foreach($authorizations->permissions as $permission)
        {
            if($config_permission == $permission ?? false)
            {
                return true;
            }
        }
    }
    /**
     * Summary of hidden
     * @var array<string, int>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Summary of casts
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'=>'hashed'
    ];
}
